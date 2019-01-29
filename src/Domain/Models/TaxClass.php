<?php

namespace BCSample\Tax\Domain\Models;

class TaxClass
{
    private $id;
    private $code;
    private $name;

    public function __construct($id = null, $code = null, $name = null)
    {
        $this->id = $id ?: "0";
        $this->code = $code ?: "US";
        $this->name = $name ?: "Brutal TAx";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }
}
