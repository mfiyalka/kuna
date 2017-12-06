<?php

namespace Mfiyalka\API\Kuna\Object;

/**
 * Class OrderBook
 * @package Mfiyalka\API\Kuna\Object
 *
 * @property object $asks - array of orders for sale
 * @property object $bids - array of orders for buy
 */
class OrderBook extends BaseObject
{
    /**
     * @var array|object
     */
    public $asks = [];

    /**
     * @var array|object
     */
    public $bids = [];

    /**
     * @var object
     */
    private $data;

    /**
     * OrderBook constructor.
     * @param $data
     */
    public function __construct($data)
    {
        if (isset($data['asks'])) {
            $this->asks = $this->arrayToObject($data['asks']);
        }

        if (isset($data['bids'])) {
            $this->bids = $this->arrayToObject($data['bids']);
        }

        $this->data = $this->arrayToObject($data);
    }

    /**
     * @return object
     */
    public function all()
    {
        return $this->data;
    }
}
