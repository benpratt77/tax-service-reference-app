<?php
namespace  BCSample\Tax\Helper;
use League\Fractal\Serializer\DataArraySerializer;

class Serializer extends DataArraySerializer
{
    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return $data;
    }

    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return $data;
    }

    /**
     * @return array
     */
    public function null(){
        return [];
    }
}