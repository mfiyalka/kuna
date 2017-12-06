<?php

namespace Mfiyalka\API\Kuna\Object;

/**
 * Class User
 * @package Mfiyalka\API\Kuna\Object
 *
 * @property string $email
 * @property object $uah
 * @property object $btc
 * @property object $kun
 * @property object $gol
 * @property object $tas
 * @property object $eth
 * @property object $waves
 * @property object $bch
 * @property object $gbg
 * @property object $rmc
 * @property object $r
 */
class User extends BaseObject
{
    public $email;
    private $activated;
    private $accounts = [];

    /**
     * User constructor.
     * @param array $data
     */
    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->activated = $data['activated'];
        $this->accounts = $data['accounts'];
    }

    /**
     * @return bool
     */
    public function isActivated()
    {
        return $this->accounts == 1 ? true : false;
    }

    /**
     * @return object
     */
    public function getAccounts()
    {
        return $this->arrayToObject($this->accounts);
    }

    /**
     * @param string $name
     * @return bool|object
     */
    public function __get($name)
    {
        foreach ($this->accounts as $key => $account) {
            if ($account['currency'] == $name) {
                return $this->arrayToObject($account);
            }
        }

        return false;
    }
}
