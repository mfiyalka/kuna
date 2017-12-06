<?php

namespace Mfiyalka\API\Kuna\Object;

/**
 * Class Trades
 * @package Mfiyalka\API\Kuna\Object
 *
 * @property object $trades - trades history
 */
class Trades extends BaseObject
{
    public $trades;

    /**
     * Trades constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->trades = $this->arrayToObject($data);
    }
}
