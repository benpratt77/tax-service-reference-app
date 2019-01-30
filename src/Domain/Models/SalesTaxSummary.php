<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class SalesTaxSummary
{

    const SUMMARY_NAME = 'Brutal Tax';
    const NAME = 'name';

    private $name;
    private $rate;
    private $amount;
    private $taxClass;

    public function __construct($tax)
    {
        $this->id = self::SUMMARY_NAME;
        $this->name = self::SUMMARY_NAME;
        $this->rate = SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->amount = $tax;
        /** @var TaxClass taxClass */
        $this->taxClass = new TaxClass();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTaxClass()
    {
        return $this->taxClass;
    }
}
