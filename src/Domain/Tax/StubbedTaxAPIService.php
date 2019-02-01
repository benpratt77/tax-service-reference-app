<?php

namespace BCSample\Tax\Domain\Tax;

use BCSample\Tax\Domain\Models\Item;
use BCSample\Tax\Domain\Tax\Transformers\ItemTransformer;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use BCSample\Tax\Helper\Transformer;
use Psr\Log\LoggerInterface;

class StubbedTaxAPIService implements SimpleAPIServiceInterface
{
    const ID_VALUE = 'sample666';
    const ITEM_SINGULAR = 'item';

    /** @var LoggerInterface */
    private $logger;

    /**  @var SampleTaxLineFactory */
    private $sampleTaxLineFactory;

    /**  @var ItemTransformer */
    private $itemTransformer;

    /** @var Transformer */
    private $transformer;

    /**
     * @param LoggerInterface $logger
     * @param SampleTaxLineFactory $sampleTaxLineFactory
     * @param ItemTransformer $itemTransformer
     * @param Transformer $transformer
     */
    public function __construct(
        LoggerInterface $logger,
        SampleTaxLineFactory $sampleTaxLineFactory,
        ItemTransformer $itemTransformer,
        Transformer $transformer
    ) {
        $this->logger = $logger;
        $this->sampleTaxLineFactory = $sampleTaxLineFactory;
        $this->itemTransformer = $itemTransformer;
        $this->transformer = $transformer;
    }

    /**
     * @param array $requestPayload
     * @param null $externalId
     * @return array
     */
    public function getEstimate(array $requestPayload, $externalId = null): array
    {
        $result[SampleTaxLineFactory::EXTERNAL_ID] = $externalId ?? self::ID_VALUE;
        $this->logger->info("{$result[SampleTaxLineFactory::EXTERNAL_ID]} sent a document request");
        $result['id'] = self::ID_VALUE;
        $documents = $requestPayload[SampleTaxLineFactory::DOCUMENTS];
        foreach ($documents as $document) {

            foreach ($document[SampleTaxLineFactory::ITEMS] as $item) {
                $taxLine = $this->sampleTaxLineFactory->processItem($item, self::ITEM_SINGULAR);
                $result[SampleTaxLineFactory::ITEMS][] = $taxLine[self::ITEM_SINGULAR];
            }
            $shipping = new Item($document[SampleTaxLineFactory::SHIPPING], SampleTaxLineFactory::SHIPPING);
            $handling = new Item($document[SampleTaxLineFactory::HANDLING], SampleTaxLineFactory::HANDLING);
            $result[SampleTaxLineFactory::SHIPPING] = $this->transformer->transform($shipping, $this->itemTransformer);
            $result[SampleTaxLineFactory::HANDLING] = $this->transformer->transform($handling, $this->itemTransformer);
        }

        return $result;
    }

    /**
     * At this stage we are just simulating a quote, in future we will add functionality to commit.
     * @param array $requestPayload
     * @return array
     */
    function commitQuote(array $requestPayload): array
    {
        return $this->getEstimate($requestPayload);
    }

    /**
     * At this stage we are just simulating a quote an including an externalId, in future we will add functionality to the adjust.
     * @param array $requestPayload
     * @param string $externalId
     * @return array
     */
    function adjustQuote(array $requestPayload, string $externalId): array
    {
        return $this->getEstimate($requestPayload, $externalId);
    }
}
