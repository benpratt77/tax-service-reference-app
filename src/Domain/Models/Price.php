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

    public function __construct(array $data, $taxCode)
    {
        $exempt = ($taxCode == 'yeah-nah') ? true : false;
        $this->totalTax = $exempt ? 0 : $this->calculateTax($data[self::AMOUNT]);
        $this->amountInclusive = $data[self::AMOUNT] + $this->totalTax;
        $this->amountExclusive = $data[self::AMOUNT];
        $this->taxRate = $exempt ? 0 : SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->salesTaxSummary = new SalesTaxSummary($this->totalTax, $exempt, $taxCode);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [];
        $output['amount_inclusive'] = $this->amountInclusive;
        $output['amount_exclusive'] = $this->amountExclusive;
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
        if ($exempt) {
            return 0;
        }
        if ($amount > 0) {
            return round($amount * SampleTaxLineFactory::SAMPLE_TAX_RATE, 2);
        }
        return $amount;
    }
}
