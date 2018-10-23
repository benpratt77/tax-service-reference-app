<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class SalesTaxSummary {


    const SUMMARY_NAME = 'Brutal Tax';

    private $name;
    private $rate;
    private $amount;

    public function __construct($tax)
    {
        $this->name = self::SUMMARY_NAME;
        $this->rate = SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->amount = $tax;
        $this->taxClass = [
            'class_id' => '0',
            'name' => self::SUMMARY_NAME,
            "code" => "US"
        ];
    }

    public function toArray(){
        $output = [];
        $output['name'] = $this->name;
        $output['rate'] = $this->rate;
        $output['amount'] = $this->amount;
        $output['tax_class'] = $this->taxClass;
        return $output;
    }
}