<?php

namespace Test\Domain\Tax\Validators;

use BCSample\Tax\Domain\Tax\Validators\TaxEstimateValidator;
use PHPUnit\Framework\TestCase;

class EstimateValidatorTest extends TestCase
{
    /** @var TaxEstimateValidator */
    private $validator;

    public function setUp()
    {
        parent::setUp();
        $this->validator = new TaxEstimateValidator();
    }

    public function testFailsWithNoDocuments()
    {
        $data = [];
        $result = $this->validator->validateEstimatePayload($data);
        $this->assertFalse($result);
    }

    public function testFailsWithNoItems()
    {
        $data = ['documents' =>
            [
                [
                    'id' => 1,
                ]
            ]
        ];
        $result = $this->validator->validateEstimatePayload($data);
        $this->assertFalse($result);
    }

    public function testFailsWithNoShipping()
    {
        $data = ['documents' =>
            [
                [
                    'id' => 1,
                    "items" => [],
                    "handling" => [],
                ]
            ]
        ];
        $result = $this->validator->validateEstimatePayload($data);
        $this->assertFalse($result);
    }

    public function testFailsWithNoHandling()
    {
        $data = ['documents' =>
            [
                [
                    'id' => 1,
                    "items" => [],
                    "shipping" => [],
                ]
            ]
        ];
        $result = $this->validator->validateEstimatePayload($data);
        $this->assertFalse($result);
    }

    public function testPassesWithValidData()
    {
        $data = ['documents' =>
            [
                [
                    'id' => 1,
                    "items" => [
                        [
                            "id" => 1,
                            "price" => [
                                "amount" => 20,
                                "tax_inclusive" => true,
                            ]
                        ]
                    ],
                    "shipping" => [
                        [
                            "id" => 1,
                            "price" => [
                                "amount" => 20,
                                "tax_inclusive" => true,
                            ]
                        ]
                    ],
                    "handling" => [
                        [
                            "id" => 1,
                            "price" => [
                                "amount" => 20,
                                "tax_inclusive" => true,
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $result = $this->validator->validateEstimatePayload($data);
        $this->assertTrue($result);
    }
}
