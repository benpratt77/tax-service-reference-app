<?php

namespace BCSample\Tax\Helper;

use BCSample\Tax\Domain\Models\Item;

class SampleTaxLineFactory
{
    const SAMPLE_TAX_RATE = 0.5;
    const DOCUMENTS = 'documents';
    const ITEMS = 'items';
    const SHIPPING = 'shipping';
    const WRAPPING = 'wrapping';
    const HANDLING = 'handling';
    const EXTERNAL_ID = 'external_id';

    /**
     * Processes an item from the document form submission.
     * This can either be a purchased Item, Shipping or Handling
     *
     * @param array $data
     * @param string $type
     * @param bool $taxExempt
     * @return array
     */
    public function processItem(array $data, string $type, $taxExempt = false): array
    {
        $item = new Item($data, $type, $taxExempt);
        $taxDetails[$type] = $item->toArray();
        return $taxDetails;
    }
}