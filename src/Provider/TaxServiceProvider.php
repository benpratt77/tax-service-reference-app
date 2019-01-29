<?php

namespace BCSample\Tax\Provider;

use BCSample\Tax\Domain\Tax\TaxAPIController;
use BCSample\Tax\Domain\Tax\StubbedTaxAPIService;
use BCSample\Tax\Domain\Tax\Validators\TaxAdjustValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxCommitValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxEstimateValidator;
use BCSample\Tax\Helper\SampleTaxLineFactory;
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
        $app[SampleTaxLineFactory::class] = new SampleTaxLineFactory();
        $app[StubbedTaxAPIService::class] = new StubbedTaxAPIService(
            $app['monolog'],
            $app[SampleTaxLineFactory::class]
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
