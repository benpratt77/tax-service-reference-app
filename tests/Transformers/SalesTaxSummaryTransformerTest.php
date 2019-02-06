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

    public function setUp()
    {
        parent::setUp();

        $this->taxClassTransformer = $this->prophesize(TaxClassTransformer::class);
        $this->salesTaxSummaryTransformer = new SalesTaxSummaryTransformer($this->taxClassTransformer->reveal());
    }

    public function testTransformerReturnsCorrectData()
    {
            /** @var SalesTaxSummary $salesTaxSummary */
            $salesTaxSummary = $this->prophesize(SalesTaxSummary::class);
            $salesTaxSummary->getId()->willReturn(1);
            $salesTaxSummary->getName()->willReturn('Brutal Tax');
            $salesTaxSummary->getAmount()->willReturn(50);
            $salesTaxSummary->getRate()->willReturn(0.5);

            $result = $this->salesTaxSummaryTransformer->transform($salesTaxSummary->reveal());

            $this->assertEquals(1, $result['id']);
            $this->assertEquals('Brutal Tax', $result['name']);
            $this->assertEquals(50, $result['amount']);
            $this->assertEquals(0.5, $result['rate']);
    }
}
