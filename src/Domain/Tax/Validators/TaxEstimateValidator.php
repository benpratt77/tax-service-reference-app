<?php

namespace BCSample\Tax\Domain\Tax\Validators;

class TaxEstimateValidator
{

    /**
     * @param $requestPayload
     * @return bool
     */
    public function validateEstimatePayload($requestPayload): bool
    {
        //@todo validate against no store-hash in the header.
        $documents = $requestPayload['documents'];
        if (!$documents) {
            return false;
        }
        foreach ($documents as $document) {
            if (!isset($document['shipping']) || !isset($document['handling'])) {
                return false;
            }

            $items = $document['items'];
            if (!$items) {
                return false;
            }

            foreach ($items as $item) {
                if (!isset($item['id']) || !isset($item['price'])) {
                    return false;
                }
                if (!isset($item['price']['amount']) || !isset($item['price']['tax_inclusive'])) {
                    return false;
                }
            }
        }

        return true;
    }
}
