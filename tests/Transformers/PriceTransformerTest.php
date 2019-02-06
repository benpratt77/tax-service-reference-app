<?php

use BCSample\Tax\Domain\Models\Price;
use BCSample\Tax\Domain\Tax\Transformers\PriceTransformer;
use BCSample\Tax\Domain\Tax\Transformers\SalesTaxSummaryTransformer;
use PHPUnit\Framework\TestCase;

class PriceTransformerTest extends TestCase
{
    /** @var Price */
    private $price;

    /** @var PriceTransformer */
    private $priceTransformer;

    /** @var SalesTaxSummaryTransformer */
    private $salesTaxSummaryTransformer;

    public function setUp()
    {
        parent::setUp();
        $this->price = $this->prophesize(Price::class);
        $this->price->getAmountInclusive()->willReturn(30);
        $this->price->getTotalTax()->willReturn(10);
        $this->price->getAmountExclusive()->willReturn(20);

        $this->salesTaxSummaryTransformer = $this->prophesize(SalesTaxSummaryTransformer::class);
        $this->priceTransformer = new PriceTransformer($this->salesTaxSummaryTransformer->reveal());
    }

    public function testTransformerReturnsCorrectData()
    {
        $result = $this->priceTransformer->transform($this->price->reveal());

        $this->assertEquals(30, $result['amount_inclusive']);
        $this->assertEquals(20, $result['amount_exclusive']);
        $this->assertEquals(10, $result['total_tax']);
    }
}
