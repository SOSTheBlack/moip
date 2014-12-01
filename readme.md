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
        'expiration'    => '2011-11-11 ',
        'workingDays'   => false,
        'instructions'  => [
            'firstLine',
            'secondLine'
        ],
        'uriLogo' => 'http://seusite.com.br/logo.gif',
    ],
    message' => [
        'message 01',
        'message 02',
        'message 03'
    ]
];

Moip::postOrder($data);
Moip::response();
Moip::response()->getXML;
Moip::response()->replyXML;
Moip::response()->token;
Moip::response()->url;

```