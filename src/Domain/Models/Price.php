<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class Price
{
    const AMOUNT = 'amount';
    const PRICE = 'price';

    private $amountInclusive;
    private $amountExclusive;
    private $taxRate;
    private $totalTax;
    private $salesTaxSummary;

    public function __construct(array $data, $taxCode, $id, $name)
    {
        $exempt = $this->isTaxExempt($taxCode, $data[self::AMOUNT]);
        $this->totalTax = $this->calculateTax($data[self::AMOUNT]);

        $this->amountInclusive = $data[self::AMOUNT];

        $this->amountExclusive = $data[self::AMOUNT];
        if (!$data['tax_inclusive']) {
            $this->amountInclusive += $this->totalTax;
        }else{
            $this->amountExclusive -= $this->totalTax;
        }

        $this->taxRate = $exempt ? 0 : SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->salesTaxSummary = new SalesTaxSummary($this->totalTax, $exempt, $taxCode, $id, $name);
    }

    private function isTaxExempt($taxCode, $amount): bool
    {
        if($taxCode === 'yeah-nah') {
            return true;
        }

        if($amount <= 0){
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [];
        $output['amount_inclusive'] = round($this->amountInclusive, 2);
        $output['amount_exclusive'] = round($this->amountExclusive, 2);
        $output['total_tax'] = $this->totalTax;
        $output['tax_rate'] = $this->taxRate;
        $output['sales_tax_summary'] = $this->salesTaxSummary->toArray();

        return $output;
    }

    /**
     * @param float $amount
     * @param bool $exempt
     * @return float
     */
    private function calculateTax(float $amount, $exempt = false): float
    {
        if ($exempt || $amount < 0) {
            return 0;
        }
        if ($amount > 0) {
            return round($amount * SampleTaxLineFactory::SAMPLE_TAX_RATE, 2);
        }
        return $amount;
    }
}
