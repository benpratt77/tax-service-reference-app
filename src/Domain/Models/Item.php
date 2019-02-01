<?php

namespace BCSample\Tax\Domain\Models;

class Item
{
    /** @var string */
    private $id;

    /** @var Price */
    private $price;

    /** @var string  */
    private $type;

    /** @var null|bool  */
    private $wrapping;

    /**
     * @param array $data
     * @param string $type
     */
    public function __construct(array $data, string $type)
    {
        $this->id = $data['id'];
        $this->price = new Price($data['price']);
        $this->type = $type;
        $this->wrapping = null;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return null|bool
     */
    public function getWrapping()
    {
        return $this->wrapping;
    }
}
