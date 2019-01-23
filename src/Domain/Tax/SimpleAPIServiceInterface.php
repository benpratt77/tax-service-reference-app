<?php

namespace BCSample\Tax\Domain\Tax;

interface SimpleAPIServiceInterface
{
    /**
     * @param array $requestPayload An array conforming to the BigCommerce OpenTaxApi Request format
     * @return array An array formatted according to the BigCommerce OpenTaxApi Response format
     */
    function getEstimate(array $requestPayload);

    /**
     * @param array $requestPayload An array conforming to the BigCommerce OpenTaxApi Request format
     * @return array Confirmation that the Quote has been commit to file.
     */
    function commitQuote(array $requestPayload);
}
