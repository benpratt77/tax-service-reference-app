<?php

namespace BCSample\Tax\Domain\Tax;

use BCSample\Tax\Domain\Tax\Validators\TaxAdjustValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxCommitValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxEstimateValidator;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TaxAPIController
{
    const BC_HEADER = 'X-BC-Store-Hash';
    const ERROR_INCORRECT_HEADERS = 'Incorrect headers provided';
    const ERROR_BADLY_FORMATTED = 'Badly Formatted request';
    const SAMPLE_TAX = 'SampleTax';
    const ID = 'id';


    /** @var StubbedTaxAPIService */
    private $taxAPIService;

    /** @var TaxEstimateValidator */
    private $taxEstimateValidator;

    /** @var TaxCommitValidator */
    private $taxCommitValidator;

    /** @var TaxAdjustValidator */
    private $taxAdjustValidator;

    /**
     * TaxAPIController constructor.
     * @param StubbedTaxAPIService $taxAPIService
     * @param TaxEstimateValidator $taxEstimateValidator
     * @param TaxCommitValidator $taxCommitValidator
     * @param TaxAdjustValidator $taxAdjustValidator
     */
    public function __construct(
        StubbedTaxAPIService $taxAPIService,
        TaxEstimateValidator $taxEstimateValidator,
        TaxCommitValidator $taxCommitValidator,
        TaxAdjustValidator $taxAdjustValidator
    ) {
        $this->taxAPIService = $taxAPIService;
        $this->taxEstimateValidator = $taxEstimateValidator;
        $this->taxCommitValidator = $taxCommitValidator;
        $this->taxAdjustValidator = $taxAdjustValidator;
    }

    /**
     * Route /estimate
     * @param Request $request
     * @return JsonResponse
     */
    public function getEstimate(Request $request): JsonResponse
    {
        if (!$request->headers->get(self::BC_HEADER)) {
            return new JsonResponse($this->buildErrorResponseBody(self::ERROR_INCORRECT_HEADERS));
        }
        $requestPayload = json_decode($request->getContent(), true);
        if (!$this->taxEstimateValidator->validateEstimatePayload($requestPayload)) {
            return new JsonResponse($this->buildErrorResponseBody(self::ERROR_BADLY_FORMATTED));
        }
        try {
            $estimate = $this->taxAPIService->getEstimate($requestPayload);
            $result[SampleTaxLineFactory::DOCUMENTS][] = $estimate;
            $result[self::ID] = self::SAMPLE_TAX . rand();
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
        if (!$request->headers->get(self::BC_HEADER)) {
            return new JsonResponse($this->buildErrorResponseBody(self::ERROR_INCORRECT_HEADERS));
        }
        $requestPayload = json_decode($request->getContent(), true);
        if (!$this->taxCommitValidator->validateCommitPayload($requestPayload)) {
            return new JsonResponse($this->buildErrorResponseBody(self::ERROR_BADLY_FORMATTED));
        }
        try {
            $commit = $this->taxAPIService->commitQuote($requestPayload);
            $result[SampleTaxLineFactory::DOCUMENTS][] = $commit;
            $result[self::ID] = self::SAMPLE_TAX . rand();
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
    public function adjust(Request $request): JsonResponse
    {
        if (!$request->headers->get(self::BC_HEADER)) {
            return new JsonResponse($this->buildErrorResponseBody(self::ERROR_INCORRECT_HEADERS));
        }
        $requestPayload = json_decode($request->getContent(), true);

        if (!$this->taxAdjustValidator->validateAdjustPayload($requestPayload)) {
            return new JsonResponse($this->buildErrorResponseBody(self::ERROR_BADLY_FORMATTED));
        }
        try {
            $commit = $this->taxAPIService->adjustQuote($requestPayload);
            $result[SampleTaxLineFactory::DOCUMENTS][] = $commit;
            $result[self::ID] = self::SAMPLE_TAX . rand();
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
