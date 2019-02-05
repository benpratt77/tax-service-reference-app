<?php

namespace BCSample\Tax\Domain\Tax\Validators;

class TaxCommitValidator
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
     * @return bool
     */
    public function validateCommitPayload($requestPayload): bool
    {
        if (!$this->taxEstimateValidator->validateEstimatePayload($requestPayload)) {
            return false;
        }

        return true;
    }
}
