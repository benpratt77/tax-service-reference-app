<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class Price
{
    const AMOUNT = 'amount';
    const PRICE = 'price';

    /** @var float */
    private $amountInclusive;

    /** @var float  */
    private $amountExclusive;

    /** @var float  */
    private $taxRate;

    /** @var float  */
    private $totalTax;

    /** @var SalesTaxSummary[] */
    private $salesTaxSummary;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->totalTax = $this->calculateTax($data[self::AMOUNT]);
        $this->amountInclusive = $data[self::AMOUNT] + $this->totalTax;
        $this->amountExclusive = $data[self::AMOUNT];
        $this->taxRate = SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->salesTaxSummary = [new SalesTaxSummary($this->totalTax)];
    }

    /**
     * @return float
     */
    public function getAmountInclusive()
    {
        return $this->amountInclusive;
    }

    /**
     * @return float
     */
    public function getAmountExclusive()
    {
        return $this->amountExclusive;
    }

    /**
     * @return float
     */
    public function getTotalTax()
    {
        return $this->totalTax;
    }

    /**
     * @return SalesTaxSummary[]
     */
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
