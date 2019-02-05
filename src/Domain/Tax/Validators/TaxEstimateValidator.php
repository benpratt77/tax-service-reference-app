<?php

namespace BCSample\Tax\Domain\Tax\Validators;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class TaxEstimateValidator
{
    /**
     * @param $requestPayload
     * @return bool
     */
    public function validateEstimatePayload($requestPayload): bool
    {
        if (!isset($requestPayload[SampleTaxLineFactory::DOCUMENTS])) {
            return false;
        }
        $documents = $requestPayload[SampleTaxLineFactory::DOCUMENTS];
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
