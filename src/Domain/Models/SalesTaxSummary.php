<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class SalesTaxSummary
{

    const SUMMARY_NAME = 'BRUTAL TAX';
    const NAME = 'name';
    const SAMPLE_NAMES = ['STATE TAX', 'COUNTY TAX', 'BRUTAL TAX'];
    const TAX_CODES = ['ONE_TAX', 'TWO_TAX', 'THREE_TAX'];


    private $name;
    private $rate;
    private $amount;
    private $taxClass;
    private $taxCode;

    public function __construct($tax, $exempt, $taxCode)
    {
        $this->name = self::SUMMARY_NAME;
        $this->taxCode = $taxCode;
        $this->rate = $exempt ? 0 : SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->amount = $tax;
        /** @var TaxClass taxClass */
        $this->taxClass = new TaxClass();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $amount = $this->amount;

        $output = [];
        $divisor = 1;

        if (in_array($this->taxCode, ['SPLITTAX', 'SPLITTAX1'])) {

            switch ($this->taxCode) {
                case 'SPLITTAX':
                    $divisor = 2;
                    $output[] = $this->getSummaryLines(
                        self::SAMPLE_NAMES[0],
                        self::SAMPLE_NAMES[0],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );

                    $output[] = $this->getSummaryLines(
                        self::SAMPLE_NAMES[1],
                        self::SAMPLE_NAMES[1],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );
                break;

                case 'SPLITTAX1':
                    $divisor = 3;
                    $output[] = $this->getSummaryLines(
                        self::SAMPLE_NAMES[0],
                        self::SAMPLE_NAMES[0],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );

                    $output[] = $this->getSummaryLines(
                        self::SAMPLE_NAMES[1],
                        self::SAMPLE_NAMES[1],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );

                    $output[] = $this->getSummaryLines(
                        self::SAMPLE_NAMES[2],
                        self::SAMPLE_NAMES[2],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );
                    break;
            }
        } else {
            $output[] = $this->getSummaryLines(
                self::SUMMARY_NAME,
                $this->name,
                $amount,
                $this->taxClass->toArray(),
                $divisor
            );
        }

        return $output;
    }

    public function getSummaryLines($id, $name, $amount, $tax_class, $divisor)
    {
        $output = [];
        $output[self::NAME] = $name;
        $output['rate'] = $this->rate;
        $output['amount'] = $amount / $divisor;
        $output['tax_class'] = $tax_class;
        $output['id'] = $id;

        return $output;
    }
}
