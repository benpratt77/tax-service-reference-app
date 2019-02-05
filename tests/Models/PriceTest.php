<?php

namespace Test\Domain\Models;

use BCSample\Tax\Domain\Models\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testPricePersistsData()
    {
        $data = [
            'amount' => 20.00,
            'tax_inclusive' => false
        ];
        $price = new Price($data);

        $this->assertEquals(10, $price->getTotalTax());
        $this->assertEquals(20, $price->getAmountExclusive());
        $this->assertEquals(30, $price->getAmountInclusive());
    }
}
