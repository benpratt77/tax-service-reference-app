<?php

namespace BCSample\Tax\Helper;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class Transformer
{
    /** @var Manager $manager */
    private $manager;

    public function __construct()
    {
        $this->manager = new Manager();
        $this->manager->setSerializer(new Serializer());
    }

    public function transform($resource, $resourceTransformer)
    {
        $result = $this->manager->createData(new Item($resource, $resourceTransformer));

        return $result->toArray();
    }
}
