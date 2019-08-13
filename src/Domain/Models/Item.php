<?php

namespace BCSample\Tax\Domain\Models;

use BCSample\Tax\Helper\SampleTaxLineFactory;

class Item
{
    private $id;
    private $price;
    private $type;
    private $wrapping = null;

    public function __construct($data, string $type, $customerIsTaxExempt = false)
    {
        $taxCode = $data['tax_class']['code'];
        if ($customerIsTaxExempt) {
            $taxCode = "yeah-nah";
        }
        $this->id = $data['id'];
        $this->price = new Price($data['price'], $taxCode);
        $this->type = $type;
        if ($data[SampleTaxLineFactory::WRAPPING]) {
            $this->wrapping = new Item($data[SampleTaxLineFactory::WRAPPING], SampleTaxLineFactory::WRAPPING, $customerIsTaxExempt);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [];
        $output['id'] = $this->id;
        $output['price'] = $this->price->toArray();
        $output['type'] = $this->type;
        if ($this->type === 'item') {
            $output['wrapping'] = $this->wrappingToArray();
        }

        return $output;
    }

    public function wrappingToArray()
    {
        if ($this->wrapping === null) {
            return null;
        }
        $element = $this->wrapping->toArray();
        unset($element[SampleTaxLineFactory::WRAPPING]);
        $output = $element;


        return $output;
    }
}
