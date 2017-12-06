<?php

namespace Mfiyalka\API\Kuna\Object;

/**
 * Class Ticket
 * @package Mfiyalka\API\Kuna\Object
 *
 * @property string $at    - server time
 * @property string $buy   - price for buy
 * @property string $sell  - price for sale
 * @property string $low   - the lowest price of the trade in 24 hours
 * @property string $high  - the highest price of the trade in 24 hours
 * @property string $last  - price of the last trade
 * @property string $vol   - volume of trading in base currency for 24 hours
 * @property string $price - total price of trading in quote currency for 24 hours
 */
class Ticket extends BaseObject
{
    /**
     * @var array
     */
    private $properties = [];

    /**
     * CreateOrder constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->properties = $data;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($name == 'at') {
            return $this->properties['at'];
        } elseif (!empty($this->properties['ticker'][$name])) {
            return $this->properties['ticker'][$name];
        }

        throw new \Exception('Undefined property '.$name.' referenced.');
    }

    /**
     * @return object
     */
    public function all()
    {
        return $this->arrayToObject($this->properties);
    }
}
