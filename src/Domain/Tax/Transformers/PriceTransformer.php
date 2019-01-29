<?php

namespace BCSample\Tax\Domain\Tax\Transformers;

use BCSample\Tax\Domain\Models\Price;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use League\Fractal\TransformerAbstract;

class PriceTransformer extends TransformerAbstract
{
    /** @var SalesTaxSummaryTransformer */
    private $salesTaxSummaryTransformer;

    /**
     * PriceTransformer constructor.
     * @param SalesTaxSummaryTransformer $salesTaxSummaryTransformer
     */
    public function __construct(SalesTaxSummaryTransformer $salesTaxSummaryTransformer)
    {
        $this->salesTaxSummaryTransformer = $salesTaxSummaryTransformer;
        $this->defaultIncludes = [
            'salesTaxSummary'
        ];
    }

    public function transform(Price $price)
    {
        return [
            'amount_inclusive' => $price->getAmountInclusive(),
            'amount_exclusive' => $price->getAmountExclusive(),
            'total_tax' => $price->getTotalTax(),
            'tax_rate' => SampleTaxLineFactory::SAMPLE_TAX_RATE
        ];
    }

    public function includeSalesTaxSummary(Price $price)
    {
        return $this->item($price->getSalesTaxSummary(), $this->salesTaxSummaryTransformer);
    }
}
