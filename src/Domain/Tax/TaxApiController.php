<?php

namespace BCSample\Tax\Domain\Tax;

use BCSample\Tax\Domain\Tax\Validators\TaxCommitValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxEstimateValidator;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TaxAPIController
{
    /** @var StubbedTaxAPIService */
    private $taxAPIService;

    /** @var TaxEstimateValidator */
    private $taxEstimateValidator;

    /** @var TaxCommitValidator */
    private $taxCommitValidator;

    /**
     * TaxAPIController constructor.
     * @param StubbedTaxAPIService $taxAPIService
     * @param TaxEstimateValidator $taxEstimateValidator
     * @param TaxCommitValidator $taxCommitValidator
     */
    public function __construct(
        StubbedTaxAPIService $taxAPIService,
        TaxEstimateValidator $taxEstimateValidator,
        TaxCommitValidator $taxCommitValidator
    ) {
        $this->taxAPIService = $taxAPIService;
        $this->taxEstimateValidator = $taxEstimateValidator;
        $this->taxCommitValidator = $taxCommitValidator;
    }

    /**
     * Route /estimate
     * @param Request $request
     * @return JsonResponse
     */
    public function getEstimate(Request $request): JsonResponse
    {
        $requestPayload = json_decode($request->getContent(), true);

        if (!$this->taxEstimateValidator->validateEstimatePayload($requestPayload)) {
            return new JsonResponse($this->buildErrorResponseBody('Badly formatted request'));
        }
        try {
            // Simply gets a base response without content
            $estimate = $this->taxAPIService->getEstimate($requestPayload);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function commit(Request $request): JsonResponse
    {
        $requestPayload = json_decode($request->getContent(), true);

        if (!$this->taxCommitValidator->validateCommitPayload($requestPayload)) {
            return new JsonResponse($this->buildErrorResponseBody('Badly Formatted request'));
        }
        try {
            $commit = $this->taxAPIService->commitQuote($requestPayload);
            $result['documents'][] = $commit;
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
}
