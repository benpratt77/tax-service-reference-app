<?php

namespace BCSample\Tax\Domain\Tax;

use BCSample\Tax\Domain\Tax\Validators\TaxAdjustValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxCommitValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxEstimateValidator;
use BCSample\Tax\Domain\Tax\Validators\TaxVoidValidator;
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

    /** @var TaxVoidValidator */
    private $taxVoidValidator;

    /**
     * TaxAPIController constructor.
     * @param StubbedTaxAPIService $taxAPIService
     * @param TaxEstimateValidator $taxEstimateValidator
     * @param TaxCommitValidator $taxCommitValidator
     * @param TaxAdjustValidator $taxAdjustValidator
     * @param TaxVoidValidator $taxVoidValidator
     */
    public function __construct(
        StubbedTaxAPIService $taxAPIService,
        TaxEstimateValidator $taxEstimateValidator,
        TaxCommitValidator $taxCommitValidator,
        TaxAdjustValidator $taxAdjustValidator,
        TaxVoidValidator $taxVoidValidator
    ) {
        $this->taxAPIService = $taxAPIService;
        $this->taxEstimateValidator = $taxEstimateValidator;
        $this->taxCommitValidator = $taxCommitValidator;
        $this->taxAdjustValidator = $taxAdjustValidator;
        $this->taxVoidValidator = $taxVoidValidator;
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
            $result[self::ID] = $requestPayload['id'];
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
            $result[self::ID] = $requestPayload['id'];
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
        $id = $request->get('id');
        $requestPayload = json_decode($request->getContent(), true);

        if (!$this->taxAdjustValidator->validateAdjustPayload($requestPayload, $id)) {
            return new JsonResponse($this->buildErrorResponseBody(self::ERROR_BADLY_FORMATTED));
        }
        try {
            $commit = $this->taxAPIService->adjustQuote($requestPayload, $id);
            $result[SampleTaxLineFactory::DOCUMENTS][] = $commit;
//            $result['adjust_description'] = $requestPayload['adjust_description'] ?? 'no reason provided';
            $result[self::ID] = $requestPayload['id'];
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
    public function void(Request $request): JsonResponse
    {
        $id = $request->get('id');
        if (!$this->taxVoidValidator->validate($id)) {
            return new JsonResponse($this->buildErrorResponseBody('No Id Provided'));
        }
        $this->taxAPIService->void();

        $value = [
            'success' => true

        ];
        return new JsonResponse($value);
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
