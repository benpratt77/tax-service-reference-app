<?php

namespace BCSample\Tax\Domain\TaxEstimates;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TaxEstimateAPIController
{
    /** @var StubbedTaxEstimateAPIService */
    private $estimateAPIService;

    /**
     * TaxEstimateAPIController constructor.
     * @param StubbedTaxEstimateAPIService $estimateAPIService
     */
    public function __construct(StubbedTaxEstimateAPIService $estimateAPIService)
    {
        $this->estimateAPIService = $estimateAPIService;
    }

    /**
     * Route /estimate
     * @param Request $request
     * @return JsonResponse
     */
    public function getEstimate(Request $request): JsonResponse
    {
        $requestPayload = json_decode($request->getContent(), true);

        if (!$this->validatePayload($requestPayload)) {
            return new JsonResponse($this->buildErrorResponseBody('Badly formatted request'));
        }
        try {
            // Simply gets a base response without content
            $estimate = $this->estimateAPIService->getEstimate($requestPayload);
            $result['documents'][] = $estimate;
            $result['id'] = 'SampleTax' . rand();

        } catch (Exception $e) {
            return new JsonResponse($this->buildErrorResponseBody($e->getMessage()));
        }

        $response = new JsonResponse($result);
        $response->setEncodingOptions(JSON_PRESERVE_ZERO_FRACTION);
        return $response;
    }

    /**
     * @param string $message
     * @return array
     */
    private function buildErrorResponseBody(string $message): array
    {
        return [
            'messages' => [
                [
                    'text' => $message,
                    'type' => 'ERROR',
                ]
            ]
        ];
    }

    /**
     * @param $requestPayload
     * @return bool
     */
    private function validatePayload($requestPayload): bool
    {
        //@todo valdiate against no storehash in the header.

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
