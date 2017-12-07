# API Kuna

## General

[Kuna](https://kuna.io) API wrapper

Install:

```php
composer require mfiyalka/kuna "*"
```

```php
...
"require": {
        "mfiyalka/kuna": "*"
    }
...
```

## Examples:

### Server Time
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;

$kuna = new ApiKuna();
$timestamp = $kuna->getTimestamp();
echo $timestamp; //1512632791
```

### Recent Market Data
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;
use Mfiyalka\API\Kuna\Market;

$kuna = new ApiKuna();
$data = $kuna->getTickers(Market::BTC_UAH);

$data->all();
$data->at;
$data->buy;
$data->sell;
...
```

### Order Book
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;
use Mfiyalka\API\Kuna\Market;

$kuna = new ApiKuna();
$data = $kuna->getOrderBook(Market::BTC_UAH);

$all = $data->all();
$asks = $data->asks;
$bids = $data->bids;
```

### Trades History
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;
use Mfiyalka\API\Kuna\Market;

$kuna = new ApiKuna();
$data = $kuna->getTrades(Market::BTC_UAH);

$trades = $data->trades;

```

### Information About the User and Assets
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;

$kuna = new ApiKuna();
$kuna->setPublicKey('***');
$kuna->setPrivateKey('***');

$me = $kuna->getMe();
$email = $me->email;
$btc = $me->btc;
...
$accounts = $me->getAccounts();
```

### Order Placing
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;
use Mfiyalka\API\Kuna\Market;

$kuna = new ApiKuna();
$kuna->setPublicKey('***');
$kuna->setPrivateKey('***');

$result = $kuna->createOrder(
    'buy',
    '0.05',
    Market::BTC_UAH,
    '400000'
);

$id = $result->id;
$side = $result->side;
$ord_type = $result->ord_type;
...
```

### Order Cancel
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;

$kuna = new ApiKuna();
$kuna->setPublicKey('***');
$kuna->setPrivateKey('***');

$result = $kuna->deleteOrder('1340811');

$id = $result->id;
$side = $result->side;
$ord_type = $result->ord_type;
```

### Active User Orders
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;
use Mfiyalka\API\Kuna\Market;

$kuna = new ApiKuna();
$kuna->setPublicKey('***');
$kuna->setPrivateKey('***');

$result = $kuna->getMyOrders(Market::BTC_UAH);

$all = $result->all();
```

### User Trade History
```php
<?php

use Mfiyalka\API\Kuna\ApiKuna;
use Mfiyalka\API\Kuna\Market;

$kuna = new ApiKuna();
$kuna->setPublicKey('***');
$kuna->setPrivateKey('***');

$result = $kuna->getMyTrades(Market::BTC_UAH);

$trades = $result->trades;
```

## Change log

* Version 1.0