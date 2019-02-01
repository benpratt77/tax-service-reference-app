<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class SalesTaxSummary
{
    const SUMMARY_NAME = 'Brutal Tax';
    const NAME = 'name';

    /** @var string  */
    private $name;

    /** @var float  */
    private $rate;

    /** @var float */
    private $amount;

    /** @var TaxClass  */
    private $taxClass;

    /**
     * @param $tax
     */
    public function __construct(float $tax)
    {
        $this->id = self::SUMMARY_NAME;
        $this->name = self::SUMMARY_NAME;
        $this->rate = SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->amount = $tax;
        /** @var TaxClass taxClass */
        $this->taxClass = new TaxClass();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return TaxClass
     */
    public function getTaxClass()
    {
        return $this->taxClass;
    }
}
