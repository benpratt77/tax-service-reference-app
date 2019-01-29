<?php

namespace BCSample\Tax\Domain\Tax\Validators;

use BCSample\Tax\Helper\SampleTaxLineFactory;

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
        // Adjust requires an external_id in order to know which document to update.
        // At present this is just checking for the keys existence.
        // In future we can check that the value has been saved. But at present Heroku is preventing us from storing these details.
        if (!$id) {
            return false;
        }
        if (!$this->taxEstimateValidator->validateEstimatePayload($requestPayload)) {
            return false;
        }

        return true;
    }
}
