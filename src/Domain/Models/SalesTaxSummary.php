<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class SalesTaxSummary
{
    const NAME = 'name';
    const SAMPLE_NAMES = ['STATE TAX', 'COUNTY TAX', 'BRUTAL TAX'];
    const SUMMARY_NAME = 'BRUTAL TAX';

    private $amount;
    private $name;
    private $rate;
    private $taxClass;
    private $taxCode;

    public function __construct($tax, $exempt, $taxCode, $id, $name)
    {
        $this->name = self::SUMMARY_NAME;
        $this->taxCode = $taxCode;
        $this->rate = $exempt ? 0 : SampleTaxLineFactory::SAMPLE_TAX_RATE;
        $this->amount = $tax;
        /** @var TaxClass taxClass */
        $this->taxClass = new TaxClass($id, $taxCode, $name);
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
                        "0",
                        self::SAMPLE_NAMES[0],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );

                    $output[] = $this->getSummaryLines(
                        "1",
                        self::SAMPLE_NAMES[1],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );
                    break;

                case 'SPLITTAX1':
                    $divisor = 3;
                    $output[] = $this->getSummaryLines(
                        "0",
                        self::SAMPLE_NAMES[0],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );

                    $output[] = $this->getSummaryLines(
                        "1",
                        self::SAMPLE_NAMES[1],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );

                    $output[] = $this->getSummaryLines(
                        "2",
                        self::SAMPLE_NAMES[2],
                        $amount,
                        $this->taxClass->toArray(),
                        $divisor
                    );
                    break;
            }
        } else {
            $output[] = $this->getSummaryLines(
                "0",
                $this->name,
                $amount,
                $this->taxClass->toArray(),
                $divisor
            );
        }

        return $output;
    }

    /**
     * @param $id
     * @param $name
     * @param $amount
     * @param $tax_class
     * @param $divisor
     * @return array
     */
    public function getSummaryLines($id, $name, $amount, $tax_class, $divisor): array
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
