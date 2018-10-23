<?php

namespace BCSample\Tax\Helper;


use BCSample\Tax\Domain\Models\Price;

class SampleTaxLineFactory
{
    const SAMPLE_TAX_RATE = 0.5;

    public function processLine(array $data): array
    {
        $line = [];

        $price = new Price($data['price']);
        $line['price'] = $price->toArray();

        $line['id'] = $data['id'];
        $line['wrapping'] = null;
        $line['type'] = 'item';

        $taxDetails['line'] = $line;

        return $taxDetails;
    }
}