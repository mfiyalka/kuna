<?php

namespace Mfiyalka\API\Kuna\Object;

/**
 * Class BaseObject
 * @package Mfiyalka\API\Kuna\Object
 */
class BaseObject
{
    /**
     * @param array
     * @return object
     */
    protected function arrayToObject($data)
    {
        return json_decode(json_encode($data));
    }
}
