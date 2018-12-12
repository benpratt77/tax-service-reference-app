<?php

namespace BCSample\Tax\Domain\TaxEstimates;

interface SimpleEstimateAPIServiceInterface
{
    /**
     * Implement this method with any request validation, transformation and rates retrieval and response serialization logic
     *
     * @param array $requestPayload An array conforming to the BigCommerce Carrier Service Request format
     * @return array An array formatted according to the BigCommerce Carrier Service Response format
     */
    function getEstimate(array $requestPayload);
}
