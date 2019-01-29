<?php

namespace BCSample\Tax\Domain\Models;

class Item
{
    private $id;
    private $price;
    private $type;
    private $wrapping;

    public function __construct($data, string $type)
    {
        $this->id = $data['id'];
        $this->price = new Price($data['price']);
        $this->type = $type;
        $this->wrapping = null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getWrapping()
    {
        return $this->wrapping;
    }
}
