<?php

namespace BCSample\Tax\Domain\Tax;

interface SimpleAPIServiceInterface
{
    /**
     * @param array $requestPayload An array conforming to the BigCommerce OpenTaxApi Request format
     * @return array An array formatted according to the BigCommerce OpenTaxApi Response format
     */
    function getEstimate(array $requestPayload): array;

    /**
     * @param array $requestPayload An array conforming to the BigCommerce OpenTaxApi Request format
     * @return array Confirmation that the Quote has been committed.
     */
    function commitQuote(array $requestPayload): array;

    /**
     * @param array $requestPayload An array conforming to the BigCommerce OpenTaxApi Request format
     * @param string $id
     * @return array Confirmation that the Quote has been adjusted to match the update
     */
    function adjustQuote(array $requestPayload, string $id): array;

    /**
     * @return bool
     */
    function void(): bool;
}
