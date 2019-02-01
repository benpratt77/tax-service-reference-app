<?php

namespace BCSample\Tax\Domain\Tax\Validators;

class TaxAdjustValidator
{
    /** @var TaxEstimateValidator */
    private $taxEstimateValidator;

    /**
     * TaxCommitValidator constructor.
     * @param TaxEstimateValidator $taxEstimateValidator
     */
    public function __construct(TaxEstimateValidator $taxEstimateValidator)
    {
        $this->taxEstimateValidator = $taxEstimateValidator;
    }

    /**
     * @param $requestPayload
     * @param string $id
     * @return bool
     */
    public function validateAdjustPayload($requestPayload, $id): bool
    {
        if (!$id) {
            return false;
        }
        if (!$this->taxEstimateValidator->validateEstimatePayload($requestPayload)) {
            return false;
        }

        return true;
    }
}
