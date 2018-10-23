<?php

namespace BCSample\Tax\Domain\TaxEstimates;

use BCSample\Tax\Domain\Models\Price;
use BCSample\Tax\Helper\SampleFixtureLoader;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use Psr\Log\LoggerInterface;

class StubbedTaxEstimateAPIService implements SimpleEstimateAPIServiceInterface
{
    /** @var SampleFixtureLoader */
    private $fixtureLoader;

    /** @var LoggerInterface */
    private $logger;
    /**  @var SampleTaxLineFactory */
    private $sampleTaxLineFactory;


    /**
     * @param SampleFixtureLoader $fixtureLoader
     * @param LoggerInterface $logger
     * @param SampleTaxLineFactory $sampleTaxLineFactory
     */
    public function __construct(SampleFixtureLoader $fixtureLoader, LoggerInterface $logger, SampleTaxLineFactory $sampleTaxLineFactory)
    {
        $this->fixtureLoader = $fixtureLoader;
        $this->logger = $logger;
        $this->sampleTaxLineFactory = $sampleTaxLineFactory;
    }

    /**
     * @param array $requestPayload
     * @return array
     */
    public function getEstimate(array $requestPayload): array
    {
        $totalAmount = 0.0;
        $totalTax = 0.0;
        $totalTaxable = 0.0;
        $totalTaxCalculated = 0.0;

        $result['external_id'] = 'sample666';
        $result['id'] = 'sample666';


        $result['shipping'] = [
            "id" => "SHIP-234",
            "price" => [
                "amount_inclusive" => 0.0,
                "amount_exclusive" => 0.0,
                "total_tax" => 0.0,
                "tax_rate" => 0.0,
            ],
            "type" => "shipping",
            "wrapping" => null
        ];
        $result['handling'] = [
            "id" => "SHIP-123",
            "price" => [
                "amount_inclusive" => 0.0,
                "amount_exclusive" => 0.0,
                "total_tax" => 0.0,
                "tax_rate" => 0.0,

            ],
            "type" => "handling",
            "wrapping" => null
        ];
        $result['shipping']['price']['sales_tax_summary'] = [];
        $result['handling']['price']['sales_tax_summary'] = [];


        $documents = $requestPayload['documents'];
        //todo come up with a solution better then O(n^2)
        foreach ($documents as $document) {
//            $shipping = new Price($document['shipping']['price']);
//            $handling = new Price($document['handling']['price']);


            foreach ($document['items'] as $item) {
                $amount = $item['price']['amount'];
                $totalAmount += $amount;
                $totalTaxable += $amount;
                $taxLine = $this->sampleTaxLineFactory->processLine($item);
                $result['items'][] = $taxLine['line'];
                $totalTax += $taxLine['line']['tax'];
                $totalTaxCalculated += $taxLine['line']['tax'];
            }

        }
        return $result;
    }
}
