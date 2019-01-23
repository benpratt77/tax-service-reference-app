<?php

namespace BCSample\Tax\Domain\Tax;

use BCSample\Tax\Domain\Models\Item;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use Psr\Log\LoggerInterface;

class StubbedTaxAPIService implements SimpleAPIServiceInterface
{
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
        $result['external_id'] = 'sample666';
        $this->logger->info("{$result['external_id']} sent a document request");
        $result['id'] = 'sample666';
        $documents = $requestPayload['documents'];
        foreach ($documents as $document) {

            foreach ($document['items'] as $item) {
                $taxLine = $this->sampleTaxLineFactory->processItem($item, 'item');
                $result['items'][] = $taxLine['item'];
            }
            $shipping = new Item($document['shipping'], 'shipping');
            $handling = new Item($document['handling'], 'handling');
            $result['shipping'] = $shipping->toArray();
            $result['handling'] = $handling->toArray();
        }
        return $result;
    }

    /**
     * @param array $requestPayload
     * @return array
     */
    function commitQuote(array $requestPayload)
    {
        return $this->getEstimate($requestPayload);
    }
}
