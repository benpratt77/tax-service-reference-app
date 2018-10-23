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

    public function getEstimate(Request $request)
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

    private function buildErrorResponseBody(string $message)
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

    private function validatePayload($requestPayload)
    {

        //todo add in validation.
        return !is_null($requestPayload) && is_array($requestPayload);
    }
}
