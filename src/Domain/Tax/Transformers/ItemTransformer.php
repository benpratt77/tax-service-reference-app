<?php

namespace BCSample\Tax\Domain\Tax\Transformers;

use BCSample\Tax\Domain\Models\Item;
use League\Fractal\TransformerAbstract;

class ItemTransformer extends TransformerAbstract
{
    /** @var PriceTransformer */
    private $priceTransformer;

    /**
     * ItemTransformer constructor.
     * @param PriceTransformer $priceTransformer
     */
    public function __construct(PriceTransformer $priceTransformer)
    {
        $this->defaultIncludes = [
            'price'
        ];


        $this->priceTransformer = $priceTransformer;
    }

    public function transform(Item $item)
    {
        return [
            'id' => $item->getId(),
            'type' => $item->getType(),
            'wrapping' => $item->getWrapping(),
            'price' => []
        ];
    }

    public function includePrice(Item $item)
    {
        return $this->item($item->getPrice(), $this->priceTransformer);
    }
}
