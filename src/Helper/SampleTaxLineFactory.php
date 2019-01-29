<?php

namespace BCSample\Tax\Helper;

use BCSample\Tax\Domain\Models\Item;

class SampleTaxLineFactory
{
    const SAMPLE_TAX_RATE = 0.5;

    /**
     * Processes an item from the document form submission.
     * This can either be a purchased Item, Shipping or Handling
     *
     * @param array $data
     * @param string $type
     * @return array
     */
    public function processItem(array $data, string $type): array
    {
        $item = new Item($data, $type);
        $taxDetails[$type] = $item->toArray();
        return $taxDetails;
    }
}