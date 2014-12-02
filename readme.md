# MoIP Package For API v1 (Laravel 4 Package)
----------------------

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SOSTheBlack/moip/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/SOSTheBlack/moip/?branch=develop) 
[![Build Status](https://travis-ci.org/SOSTheBlack/moip.svg?branch=master)](https://travis-ci.org/SOSTheBlack/moip) 
[![Latest Stable Version](https://poser.pugx.org/sostheblack/moip/v/stable.svg)](https://packagist.org/packages/sostheblack/moip) 
[![Total Downloads](https://poser.pugx.org/sostheblack/moip/downloads.svg)](https://packagist.org/packages/sostheblack/moip) 
[![Latest Unstable Version](https://poser.pugx.org/sostheblack/moip/v/unstable.svg)](https://packagist.org/packages/sostheblack/moip) 
[![License](https://poser.pugx.org/sostheblack/moip/license.svg)](https://packagist.org/packages/sostheblack/moip)

Novo package Homologado pela equipe de desenvolviemntos do MoIP

```
$data = [
    'unique_id' => false,
    'reason'    => 'market of Natal 01',
    'payer' => [
        'name'      => 'Nome Sobrenome',
        'email'     => 'email@cliente.com.br',
        'payerId'   => 'id_usuario',
        'billingAddress' => [
            'address'       => 'Rua do Zézinho Coração',
            'number'        => '45',
            'complement'    => 'z',
            'city'          => 'São Paulo',
            'neighborhood'  => 'Palhaço Jão',
            'state'         => 'SP',
            'country'       => 'BRA',
            'zipCode'       => '01230-000',
            'phone'         => '(11)8888-8888'
        ]
    ],
    'prices'    => [
        'value' => 100,
        'adds'  => 30,
        'deduct'=> 10
    ],
    'paymentWay' => [
    	'creditCard',
    	'billet',
    	'financing',
    	'debit'	,
    	'debitCard'
    ],
    'billet' => [
        'expiration'    => 3,
        'workingDays'   => false,
        'instructions'  => [
            'firstLine',
            'secondLine'
        ],
        'uriLogo' => 'http://seusite.com.br/logo.gif',
    ],
    'message' => [
        'message 01',
        'message 02',
        'message 03'
    ],
    'url_return' => 'https://meusite.com.br/cliente/pedido/bemvindodevolta',
    'url_notification' => 'https://meusite.com.br/nasp',
    'receiver' => 'jean@comunicaweb.com.br',
    'comission' => [
        ['reason' => 'comission reason', 'receiver' => 'integracao@moip.com.br', 'value' => 5.00],
        ['reason' => 'comission reason', 'receiver' => 'integracao@moip.com.br', 'value' => 12.00, 'percentageValue' => true, 'ratePayer' => true]
    ],
    'parcel' => [
        ['min' => '2', 'max' => '4'],
        ['min' => '5', 'max' => '7', 'rate' => '1.00'],
        ['min' => '8', 'max' => '12', 'rate' => null, 'transfer' => true]
    ]
];

Moip::postOrder($data);
Moip::response();
Moip::response()->getXML;
Moip::response()->replyXML;
Moip::response()->token;
Moip::response()->url;
```

```
$parcel = [
    'login'         => 'jean@comunicaweb.com.br',
    'maxParcel'     => 12,
    'rate'          => 1.99,
    'simulatedValue'=> 100
];

Moip::parcel($parcel);
``