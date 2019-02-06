<?php

use BCSample\Tax\Domain\Models\TaxClass;
use BCSample\Tax\Domain\Tax\Transformers\TaxClassTransformer;
use PHPUnit\Framework\TestCase;

class TaxClassTest extends TestCase
{
    /** @var TaxClassTransformer */
    private $taxClassTransformer;

    /** @var TaxClass $taxClass */
    private $taxClass;

    public function setUp()
    {
        parent::setUp();
        $this->taxClassTransformer = new TaxClassTransformer();

        $this->taxClass = $this->prophesize(TaxClass::class);
        $this->taxClass->getName()->willReturn('testName');
        $this->taxClass->getId()->willReturn(0);
        $this->taxClass->getCode()->willReturn('US');
    }

    public function testTransformerReturnsCorrectData()
    {
        $result = $this->taxClassTransformer->transform($this->taxClass->reveal());

        $this->assertEquals(0, $result['class_id']);
        $this->assertEquals('testName', $result['name']);
        $this->assertEquals('US', $result['code']);
    }
}
