<?php

namespace Mfiyalka\API\Kuna\Object;

/**
 * Class Orders
 * @package Mfiyalka\API\Kuna\Object
 */
class Orders extends BaseObject
{
    private $data;
    /**
     * Order constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $this->arrayToObject($data);

        return $this;
    }

    public function all()
    {
        return $this->data;
    }
}
