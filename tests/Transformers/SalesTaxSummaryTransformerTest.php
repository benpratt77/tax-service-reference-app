<?php


use BCSample\Tax\Domain\Models\SalesTaxSummary;
use BCSample\Tax\Domain\Tax\Transformers\SalesTaxSummaryTransformer;
use BCSample\Tax\Domain\Tax\Transformers\TaxClassTransformer;
use PHPUnit\Framework\TestCase;

class SalesTaxSummaryTransformerTest extends TestCase
{
    /** @var SalesTaxSummaryTransformer */
    private $salesTaxSummaryTransformer;

    /** @var TaxClassTransformer */
    private $taxClassTransformer;

    /** @var SalesTaxSummary */
    private $salesTaxSummary;

    public function setUp()
    {
        parent::setUp();
        $this->salesTaxSummary = $this->prophesize(SalesTaxSummary::class);
        $this->salesTaxSummary->getId()->willReturn(1);
        $this->salesTaxSummary->getName()->willReturn('Brutal Tax');
        $this->salesTaxSummary->getAmount()->willReturn(50);
        $this->salesTaxSummary->getRate()->willReturn(0.5);

        $this->taxClassTransformer = $this->prophesize(TaxClassTransformer::class);
        $this->salesTaxSummaryTransformer = new SalesTaxSummaryTransformer($this->taxClassTransformer->reveal());
    }

    public function testTransformerReturnsCorrectData()
    {
        $result = $this->salesTaxSummaryTransformer->transform($this->salesTaxSummary->reveal());

        $this->assertEquals(1, $result['id']);
        $this->assertEquals('Brutal Tax', $result['name']);
        $this->assertEquals(50, $result['amount']);
        $this->assertEquals(0.5, $result['rate']);
    }
}
