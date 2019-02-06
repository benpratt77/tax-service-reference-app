<?php

use BCSample\Tax\Domain\Models\Item;
use BCSample\Tax\Domain\Models\Price;
use BCSample\Tax\Domain\Tax\Transformers\ItemTransformer;
use BCSample\Tax\Domain\Tax\Transformers\PriceTransformer;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ItemTransformerTest extends TestCase
{
    /** @var PriceTransformer */
    private $priceTransformer;

    /** @var ItemTransformer */
    private $itemTransformer;

    /** @var Item */
    private $item;

    /** @var Price */
    private $price;

    public function setUp()
    {
        parent::setUp();
        $this->item = $this->prophesize(Item::class);
        $this->item->getId()->willReturn(1);
        $this->item->getType()->willReturn('item');
        $this->item->getWrapping()->willReturn(null);
        $this->item->getPrice()->willReturn([]);

        $this->price = $this->prophesize(Price::class);

        $this->priceTransformer = $this->prophesize(PriceTransformer::class);
        $this->priceTransformer->transform(Argument::any())->willReturn(
            [
                'price' => [
                    'amount' => 20,
                    'tax_inclusive' => false,
                ]
            ]
        );
        $this->itemTransformer = new ItemTransformer($this->priceTransformer->reveal());
    }

    public function testTransformerReturnsCorrectData()
    {
        $result = $this->itemTransformer->transform($this->item->reveal());

        $this->assertEquals('item', $result['type']);
        $this->assertNull($result['wrapping']);
        $this->assertEquals(1, $result['id']);
    }
}
