<?php

namespace Test\Domain\Models;

use BCSample\Tax\Domain\Models\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testItemValuesPersist()
    {
        $data = [
            'id' => '123',
            'price' => [
                'amount' => 34.95,
                'tax_inclusive' => false
            ]
        ];

        $item = new Item($data, 'item');

        $this->assertEquals($data['id'], $item->getId());
        $this->assertEquals('item', $item->getType());
    }
}
