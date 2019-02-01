<?php

namespace BCSample\Tax\Domain\Tax\Transformers;

use BCSample\Tax\Domain\Models\TaxClass;
use League\Fractal\TransformerAbstract;

class TaxClassTransformer extends TransformerAbstract
{
    /**
     * @param TaxClass $taxClass
     * @return array
     */
    public function transform(TaxClass $taxClass)
    {
        return [
            'class_id' => $taxClass->getId(),
            'name' => $taxClass->getName(),
            'code' => $taxClass->getCode()
        ];
    }
}