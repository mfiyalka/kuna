<?php

namespace Mfiyalka\API\Kuna;

use GuzzleHttp\Client;
use Mfiyalka\API\Kuna\Object\Order;
use Mfiyalka\API\Kuna\Object\Orders;
use Mfiyalka\API\Kuna\Object\OrderBook;
use Mfiyalka\API\Kuna\Object\Ticket;
use Mfiyalka\API\Kuna\Object\Trades;
use Mfiyalka\API\Kuna\Object\User;

/**
 * Class ApiKuna
 *
 * @package Mfiyalka\API\Kuna
 * @link https://kuna.io/documents/api
 * @author Mykhailo Fiialka <mfiyalka@gmail.com>
 */
class ApiKuna
{
    /** @var Client */
    private $httpClient;

    /** @var string  */
    private $baseUrl = 'https://kuna.io/api/v2/';

    /** @var array */
    private $tickers;

    /** @var float|int  */
    private $tonce;

    /** @var string */
    private $signature;

    /** @var string */
    private $publicKey;

    /** @var string */
    private $privateKey;

    /**
     * ApiKuna constructor.
     */
    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 3.0,
        ]);

        $oClass = new \ReflectionClass(Market::class);
        $this->tickers = array_values($oClass->getConstants());
    }

    /**
     * Server Time
     *
     * @return string - unix timestamp
     */
    public function getTimestamp()
    {
        return $this->get('timestamp');
    }

    /**
     * Recent Market Data
     *
     * @param string $market
     * @return Ticket
     * @throws \Exception
     */
    public function getTickers(string $market) : Ticket
    {
        $this->isMarket($market);
        $response = $this->get('tickers/' . $market);

        return new Ticket($response);
    }

    /**
     * Order Book
     *
     * @param string $market
     * @return OrderBook
     * @throws \Exception
     */
    public function getOrderBook(string $market) : OrderBook
    {
        $this->isMarket($market);
        $response = $this->get('order_book', ['query' => ['market' => $market]]);

        return new OrderBook($response);
    }

    /**
     * Trades History
     *
     * @param string $market
     * @return Trades
     * @throws \Exception
     */
    public function getTrades($market) : Trades
    {
        $this->isMarket($market);
        $response = $this->get('trades', ['query' => ['market' => $market]]);

        return new Trades($response);
    }

    /**
     * Information About the User and Assets
     *
     * @return User
     */
    public function getMe() : User
    {
        $this->tonce = time() * 1000;
        $this->signature = hash_hmac(
            'sha256',
            "GET|/api/v2/members/me|access_key={$this->publicKey}&tonce={$this->tonce}",
            $this->privateKey
        );

        $response = $this->get('members/me', [
            'query' => [
                'access_key' => $this->publicKey,
                'tonce' => $this->tonce,
                'signature' => $this->signature
            ]
        ]);

        return new User($response);
    }

    /**
     * Order Placing
     *
     * @param $side     - buy or sell
     * @param $volume   - volume in currency
     * @param $market   - market
     * @param $price    - price for 1 currency
     * @return Order
     */
    public function createOrder(
        $side,
        $volume,
        $market,
        $price
    ) : Order {
        $this->tonce = time() * 1000;
        $this->signature = hash_hmac(
            'sha256',
            "POST|/api/v2/orders|access_key={$this->publicKey}&market={$market}&price={$price}&side={$side}&tonce={$this->tonce}&volume={$volume}",
            $this->privateKey
        );

        $response = $this->post('orders', [
            'form_params' => [
                'access_key' => $this->publicKey,
                'side' => $side,
                'volume' => $volume,
                'market' => $market,
                'price' => $price,
                'tonce' => $this->tonce,
                'signature' => $this->signature
            ]
        ]);

        return new Order($response);
    }

    /**
     * Order Cancel
     *
     * @param string $id
     * @return Order
     */
    public function deleteOrder(string $id) : Order
    {
        $this->tonce = time() * 1000;
        $this->signature = hash_hmac(
            'sha256',
            "POST|/api/v2/order/delete|access_key={$this->publicKey}&id={$id}&tonce={$this->tonce}",
            $this->privateKey
        );

        $response = $this->post('order/delete', [
            'form_params' => [
                'access_key' => $this->publicKey,
                'id' => $id,
                'tonce' => $this->tonce,
                'signature' => $this->signature
            ]
        ]);

        return new Order($response);
    }

    /**
     * Active User Orders
     *
     * @param string $market
     * @return Orders
     */
    public function getMyOrders(string $market) : Orders
    {
        $this->tonce = time() * 1000;
        $this->signature = hash_hmac(
            'sha256',
            "GET|/api/v2/orders|access_key={$this->publicKey}&market={$market}&tonce={$this->tonce}",
            $this->privateKey
        );

        $response = $this->get('orders', [
            'query' => [
                'access_key' => $this->publicKey,
                'market' => $market,
                'tonce' => $this->tonce,
                'signature' => $this->signature
            ]
        ]);

        return new Orders($response);
    }

    /**
     * User Trade History
     *
     * @param string $market
     * @return Trades
     */
    public function getMyTrades(string $market) : Trades
    {
        $this->tonce = time() * 1000;
        $this->signature = hash_hmac(
            'sha256',
            "GET|/api/v2/trades/my|access_key={$this->publicKey}&market={$market}&tonce={$this->tonce}",
            $this->privateKey
        );

        $response = $this->get('trades/my', [
            'query' => [
                'access_key' => $this->publicKey,
                'market' => $market,
                'tonce' => $this->tonce,
                'signature' => $this->signature
            ]
        ]);

        return new Trades($response);
    }

    /**
     * @param string $publicKey
     */
    public function setPublicKey(string $publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @param string $privateKey
     */
    public function setPrivateKey(string $privateKey)
    {
        $this->publicKey = $privateKey;
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return mixed
     */
    private function get($endpoint, $params = [])
    {
        return $this->sendRequest(
            'GET',
            $endpoint,
            $params
        );
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return mixed
     */
    private function post($endpoint, $params = [])
    {
        return $this->sendRequest(
            'POST',
            $endpoint,
            $params
        );
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @return mixed
     */
    private function sendRequest(
        $method,
        $endpoint,
        array $params = []
    ) {
        $response = $this->httpClient->request($method, $endpoint, $params);
        $response = $response->getBody();
        $result = \GuzzleHttp\json_decode($response, true);

        return $result;
    }

    /**
     * @param $market
     * @return bool
     * @throws \Exception
     */
    private function isMarket($market)
    {
        if (!in_array($market, $this->tickers)) {
            throw new \Exception('The market is wrong');
        }

        return true;
    }
}
