<?php

namespace BCSample\Tax\Domain\Tax;

use BCSample\Tax\Domain\Models\Item;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use Psr\Log\LoggerInterface;

class StubbedTaxAPIService implements SimpleAPIServiceInterface
{
    const SHIPPING = 'shipping';
    const HANDLING = 'handling';
    const EXTERNAL_ID = 'external_id';
    const ID_VALUE = 'sample666';
    const DOCUMENTS ='documents';
    const ITEMS = 'items';
    const ITEM_SINGULAR = 'item';

    /** @var LoggerInterface */
    private $logger;
    /**  @var SampleTaxLineFactory */
    private $sampleTaxLineFactory;

    /**
     * @param LoggerInterface $logger
     * @param SampleTaxLineFactory $sampleTaxLineFactory
     */
    public function __construct(LoggerInterface $logger, SampleTaxLineFactory $sampleTaxLineFactory)
    {
        $this->logger = $logger;
        $this->sampleTaxLineFactory = $sampleTaxLineFactory;
    }

    /**
     * @param array $requestPayload
     * @return array
     */
    public function getEstimate(array $requestPayload): array
    {
        $result[self::EXTERNAL_ID] = self::ID_VALUE;
        $this->logger->info("{$result[self::EXTERNAL_ID]} sent a document request");
        $result['id'] = self::ID_VALUE;
        $documents = $requestPayload[self::DOCUMENTS];
        foreach ($documents as $document) {

            foreach ($document[self::ITEMS] as $item) {
                $taxLine = $this->sampleTaxLineFactory->processItem($item, self::ITEM_SINGULAR);
                $result[self::ITEMS][] = $taxLine[self::ITEM_SINGULAR];
            }
            $shipping = new Item($document[self::SHIPPING], self::SHIPPING);
            $handling = new Item($document[self::HANDLING], self::HANDLING);
            $result[self::SHIPPING] = $shipping->toArray();
            $result[self::HANDLING] = $handling->toArray();
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
     * At this stage we are just simulating a quote, in future we will add functionality to the adjust.
     * @param array $requestPayload
     * @return array
     */
    function adjustQuote(array $requestPayload): array
    {
        $id = $requestPayload[self::EXTERNAL_ID];
        return $this->getEstimate($requestPayload);
    }

}
