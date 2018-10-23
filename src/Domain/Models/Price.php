<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class Price
{

    private $amountInclusive;
    private $amountExclusive;
    private $taxRate;
    private $totalTax;
    private $salesTaxSummary;

    public function __construct(array $data)
    {
        $this->totalTax = $this->calculateTax($data['amount']);
        $this->amountInclusive = $data['amount'] + $this->totalTax;
        $this->amountExclusive = $data['amount'];
        $this->taxRate = SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->salesTaxSummary = new SalesTaxSummary($this->totalTax);
    }


   public function toArray(){
        $output = [];
        $output['amount_inclusive'] = $this->amountInclusive;
        $output['amount_exclusive'] = $this->amountExclusive;
        $output['totalTax'] = $this->totalTax;
        $output['tax_rate'] = SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $output['sales_tax_summary'] = $this->salesTaxSummary->toArray();

        return $output;
   }

    //Get the tax on the tax for each line in the request.
    private function calculateTax(float $amount)
    {
        if ($amount > 0) {
            return round($amount * SampleTaxLineFactory::SAMPLE_TAX_RATE, 2);
        }
        return $amount;
    }





}