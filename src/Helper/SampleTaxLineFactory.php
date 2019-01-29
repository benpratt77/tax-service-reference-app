<?php

namespace BCSample\Tax\Helper;

use BCSample\Tax\Domain\Models\Item;
use BCSample\Tax\Domain\Tax\Transformers\ItemTransformer;

class SampleTaxLineFactory
{
    const SAMPLE_TAX_RATE = 0.5;
    const DOCUMENTS = 'documents';
    const ITEMS = 'items';
    const SHIPPING = 'shipping';
    const HANDLING = 'handling';
    const EXTERNAL_ID = 'external_id';

    /** @var ItemTransformer */
    private $itemTransformer;

    /** @var Transformer */
    private $transformer;

    /**
     * SampleTaxLineFactory constructor.
     * @param ItemTransformer $itemTransformer
     * @param Transformer $transformer
     */
    public function __construct(
        ItemTransformer $itemTransformer,
        Transformer $transformer
    ) {
        $this->itemTransformer = $itemTransformer;
        $this->transformer = $transformer;
    }

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
        $taxDetails[$type] = $this->transformer->transform($item, $this->itemTransformer);

        return $taxDetails;
    }
}