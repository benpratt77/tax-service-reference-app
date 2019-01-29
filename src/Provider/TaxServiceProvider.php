<?php

namespace BCSample\Tax\Provider;

use BCSample\Tax\Domain\Tax\TaxAPIController;
use BCSample\Tax\Domain\Tax\StubbedTaxAPIService;
use BCSample\Tax\Domain\Tax\Transformers\ItemTransformer;
use BCSample\Tax\Domain\Tax\Transformers\PriceTransformer;
use BCSample\Tax\Domain\Tax\Transformers\SalesTaxSummaryTransformer;
use BCSample\Tax\Domain\Tax\Transformers\TaxClassTransformer;
use BCSample\Tax\Domain\Tax\Validators\TaxAdjustValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxCommitValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxEstimateValidator;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use BCSample\Tax\Helper\Transformer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class TaxServiceProvider
 *
 * Silex provider to register all the bits of the tax rate service in the DI Container
 *
 * @package BCSample\Tax\Provider
 */
class TaxServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app[Transformer::class] = new Transformer();
        $app[TaxClassTransformer::class] = new TaxClassTransformer();
        $app[SalesTaxSummaryTransformer::class] = new SalesTaxSummaryTransformer($app[TaxClassTransformer::class]);
        $app[PriceTransformer::class] = new PriceTransformer($app[SalesTaxSummaryTransformer::class]);
        $app[ItemTransformer::class] = new ItemTransformer($app[PriceTransformer::class]);

        $app[SampleTaxLineFactory::class] = new SampleTaxLineFactory(
            $app[ItemTransformer::class],
            $app[Transformer::class]
        );
        $app[StubbedTaxAPIService::class] = new StubbedTaxAPIService(
            $app['monolog'],
            $app[SampleTaxLineFactory::class],
            $app[ItemTransformer::class],
            $app[Transformer::class]
        );

        $app[TaxEstimateValidator::class] = new TaxEstimateValidator();
        $app[TaxCommitValidator::class] = new TaxCommitValidator(
            $app[TaxEstimateValidator::class]
        );
        $app[TaxAdjustValidator::class] = new TaxAdjustValidator(
            $app[TaxEstimateValidator::class]
        );
        $app[TaxAPIController::class] =
            new TaxAPIController(
                $app[StubbedTaxAPIService::class],
                $app[TaxEstimateValidator::class],
                $app[TaxCommitValidator::class],
                $app[TaxAdjustValidator::class]
            );
    }
}
