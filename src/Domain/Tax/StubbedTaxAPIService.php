<?php

namespace BCSample\Tax\Domain\Tax;

use BCSample\Tax\Domain\Models\Item;
use BCSample\Tax\Helper\SampleTaxLineFactory;
use Psr\Log\LoggerInterface;

class StubbedTaxAPIService implements SimpleAPIServiceInterface
{
    const ID_VALUE = 'sample666';
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
     * @param null $externalId
     * @return array
     */
    public function getEstimate(array $requestPayload, $externalId = null): array
    {
        $result = [];
        if ($externalId) {
            $result[SampleTaxLineFactory::EXTERNAL_ID] = $externalId;
        }
        if ($requestPayload['customer']['taxability_code'] == 'breakDatTax') {
            throw new \Exception('oh noes');
        }
        $customerIsTaxExempt = ($requestPayload['customer']['taxability_code'] == "TaxEvasion") ? true : false;
        if ($externalId) {
            $this->logger->info("{$result[SampleTaxLineFactory::EXTERNAL_ID]} sent a document request");
        }
        $documents = $requestPayload[SampleTaxLineFactory::DOCUMENTS];
        foreach ($documents as $document) {
            $result['id'] = $document['id'];
            foreach ($document[SampleTaxLineFactory::ITEMS] as $item) {
                $taxLine = $this->sampleTaxLineFactory->processItem($item, self::ITEM_SINGULAR, $customerIsTaxExempt);
                $result[SampleTaxLineFactory::ITEMS][] = $taxLine[self::ITEM_SINGULAR];
            }
            $shipping = new Item($document[SampleTaxLineFactory::SHIPPING], SampleTaxLineFactory::SHIPPING, $customerIsTaxExempt);
            $handling = new Item($document[SampleTaxLineFactory::HANDLING], SampleTaxLineFactory::HANDLING, $customerIsTaxExempt);
            $result[SampleTaxLineFactory::SHIPPING] = $shipping->toArray();
            $result[SampleTaxLineFactory::HANDLING] = $handling->toArray();
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
     * @param string $id
     * @return array
     */
    function adjustQuote(array $requestPayload, string $id): array
    {
        return $this->getEstimate($requestPayload, $id);
    }

    /**
     * Since our application does not have storage we don't need to actually do anything here.
     * @return bool
     */
    function void(): bool
    {
        return true;
    }
}
