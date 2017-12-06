<?php

namespace Mfiyalka\API\Kuna\Object;

/**
 * Class Order
 * @package Mfiyalka\API\Kuna\Object
 *
 * @property $id
 * @property $side
 * @property $ord_type
 * @property $price
 * @property $avg_price
 * @property $state
 * @property $market
 * @property $created_at
 * @property $volume
 * @property $remaining_volume
 * @property $executed_volume
 * @property $trades_count
 */
class Order
{
    private $properties;

    /**
     * CreateOrder constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->properties = $data;
    }

    /**
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public function __get($name)
    {
        if (!empty($this->properties[$name])) {
            return $this->properties[$name];
        }

        throw new \Exception('Undefined property '.$name.' referenced.');
    }
}
