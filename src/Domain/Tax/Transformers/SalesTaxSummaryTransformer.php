<?php

namespace BCSample\Tax\Domain\Tax\Transformers;

use BCSample\Tax\Domain\Models\SalesTaxSummary;
use League\Fractal\TransformerAbstract;

class SalesTaxSummaryTransformer extends TransformerAbstract
{
    /** @var TaxClassTransformer */
    private $taxClassTransformer;

    /**
     * SalesTaxSummaryTransformer constructor.
     * @param TaxClassTransformer $taxClassTransformer
     */
    public function __construct(TaxClassTransformer $taxClassTransformer)
    {
        $this->taxClassTransformer = $taxClassTransformer;
        $this->defaultIncludes = [
            'tax_class'
        ];
    }

    public function transform(SalesTaxSummary $salesTaxSummary)
    {
        return [
            'id' => $salesTaxSummary->getId(),
            'name' => $salesTaxSummary->getName(),
            'rate' => $salesTaxSummary->getRate(),
            'amount' => $salesTaxSummary->getAmount()
        ];
    }

    public function includeTaxClass(SalesTaxSummary $salesTaxSummary)
    {
        return $this->item($salesTaxSummary->getTaxClass(), $this->taxClassTransformer);
    }
}