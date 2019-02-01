<?php

namespace BCSample\Tax\Domain\Models;

class TaxClass
{
    /** @var string */
    private $id;

    /** @var string */
    private $code;

    /** @var string */
    private $name;

    /**
     * @param string|null $id
     * @param string|null $code
     * @param string|null $name
     */
    public function __construct($id = null, $code = null, $name = null)
    {
        $this->id = $id ?: "0";
        $this->code = $code ?: "US";
        $this->name = $name ?: "Brutal TAx";
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
