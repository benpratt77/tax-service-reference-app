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

    public function __construct(array $data)
    {
        $this->totalTax = $this->calculateTax($data[self::AMOUNT]);
        $this->amountInclusive = $data[self::AMOUNT] + $this->totalTax;
        $this->amountExclusive = $data[self::AMOUNT];
        $this->taxRate = SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->salesTaxSummary = [new SalesTaxSummary($this->totalTax)];
    }

    public function getAmountInclusive()
    {
        return $this->amountInclusive;
    }

    public function getAmountExclusive()
    {
        return $this->amountExclusive;
    }

    public function getTotalTax()
    {
        return $this->totalTax;
    }

    public function getSalesTaxSummary()
    {
        return $this->salesTaxSummary;
    }

    /**
     * @param float $amount
     * @return float
     */
    private function calculateTax(float $amount): float
    {
        if ($amount > 0) {
            return round($amount * SampleTaxLineFactory::SAMPLE_TAX_RATE, 2);
        }
        return $amount;
    }
}
