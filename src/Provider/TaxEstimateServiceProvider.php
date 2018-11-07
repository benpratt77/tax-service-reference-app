<?php

namespace BCSample\Tax\Provider;

use BCSample\Tax\Domain\TaxEstimates\TaxEstimateAPIController;
use BCSample\Tax\Domain\TaxEstimates\StubbedTaxEstimateAPIService;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class TaxRateServiceProvider
 *
 * Silex provider to register all the bits of the tax rate service in the DI Container
 *
 * @package BCSample\Tax\Provider
 */
class TaxEstimateServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app[SampleTaxLineFactory::class] = new SampleTaxLineFactory();

        $app[StubbedTaxEstimateAPIService::class] = new StubbedTaxEstimateAPIService(
            $app['monolog'],
            $app[SampleTaxLineFactory::class]

        );
        $app[TaxEstimateAPIController::class] =
            new TaxEstimateAPIController(
                $app[StubbedTaxEstimateAPIService::class]
            );
    }
}
