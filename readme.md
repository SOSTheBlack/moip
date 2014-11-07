# MoIP (Laravel Package)
----------------------

[![Latest Stable Version](https://poser.pugx.org/sostheblack/moip/v/stable.svg)](https://packagist.org/packages/sostheblack/moip) [![Total Downloads](https://poser.pugx.org/sostheblack/moip/downloads.svg)](https://packagist.org/packages/sostheblack/moip) [![Latest Unstable Version](https://poser.pugx.org/sostheblack/moip/v/unstable.svg)](https://packagist.org/packages/sostheblack/moip) [![License](https://poser.pugx.org/sostheblack/moip/license.svg)](https://packagist.org/packages/sostheblack/moip)

Package for integrating its platform with the intermediary payment MoIP.

- `Moip::sendMoip($data);`
- `Moip::response()`;

and response

- `$moip->error`
- `$moip->response`
- `$moip->token`
- `$moip->payment_url`
- `$moip->xmlSend`
- `$moip->xmlGet`
- `Moip::response()`

![Moip](http://www.tickimg.com.br/uploads/_captura_de_tela_de.png)

## Instalation

### Laravel 4.2 and Blow

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `sostheblack/moip`.

soon in version v1.*

```
"require-dev": {
    "sostheblack/moip": "1.*"
}
```

Next, update Composer from the Terminal:

```
$ composer update
```

Once that's been completed, the next step operation is run this command in terminal

```
$ php artisan config:publish sostheblack/moip
```

A configuration file will be created in `app/config/packages/sostheblack/moip/moip.php`

Make the necessary settings and proceed to the next step

Once this operation completes, the final step is to add the service provider and facade. Open `app/config/app.php`.

Add a new item to the providers array.

```
'providers' => array(
    'Illuminate\Foundation\Providers\ArtisanServiceProvider',
    'Illuminate\Auth\AuthServiceProvider',
    ...
    'SOSTheBlack\Moip\MoipServiceProvider',
),
```

Add a new item to the facades array.

```
'aliases' => array(
    'App'        => 'Illuminate\Support\Facades\App',
    'Artisan'    => 'Illuminate\Support\Facades\Artisan',
    ...
    'Moip'       => 'SOSTheBlack\Moip\Facade',
),
```

### Laravel 5 and Abouve

coming soon

## Usage

### simple

Sent only the total sale, is configured to send data in `app/config/moip.php`
```
$data = ['values' => ['value' => $full_price_products] ];
try {
    $moip = Moip::sendMoip($data);
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Advanced

Fully customize the data sent!
```
$data = [
    'unique_id' => 100000001,
    'reason'    => 'market of Natal 01',
    'receiver'  => 'integracao@moip.com.br',
    'returnURL' => 'https://meusite.com.br/cliente/$id/pedido/pedidorealizado',
    'notificationURL' => 'https://meusite.com.br/nasp',
    'payer'     => [
        'name'      => 'user name',
        'email'     => 'integracao@moip.com.br',
        'payerId'   => 'id_user',
        'identity'  => '111.111.111-11',
        'phone'     => '(11) 1111-1111)',
        'billingAddress' => [
            'address'   => 'Street Love',
            'number'    => 45,
            'complement'=> 'plaza',
            'city'      => 'São Paulo',
            'neighborhood' => 'Love',
            'state'     => 'SP',
            'country'   => 'BRA',
            'zipCode'   => '01230-000',
            'phone'     => '(11) 1 1111-1111)'
        ]
    ],    
    'parcel'    => [
        'min'       => 2, 
        'max'       => 12, 
        'rate'      => 1.5, 
        'transfer'  => true
    ],
    'values'    => [
        'value' => $full_price_products , 
        'adds'  => $freight, 
        'deduct'=> $coupon
    ],
    'comission' => [
        'value'           => 7, 
        'reason'          => 'Taxa MoIP', 
        'ratePayer'       => true,
        'percentageValue' => true,
        'receiver'        => 'suporte@moip.com.br',
    ],
    'billet' => [
        'expiration' => 3,
        'workingDays'=> true,
        'instructions' => [
            'firstLine' => 'First line of comment of billet',
            'secondLine'=> 'Second line of comment of billet',
            'lastLine'  => 'Last line of comment of billet'
        ],
        'urlLogo' => 'http://seutie.com.br/logo.png'
    ],
    'message' => [
        'firstLine' => 'First comment of checkout',
        'secondLine'=> 'Second comment of checkout',
        'lastLine'  => 'Last comment of checkout'
    ],
    'payment' => [
        'creditCard'=> true,
        'billet'    => false,
        'financing' => false,
        'debit'     => false,
        'debitCard' => false
    ]
];
try {
    $moip = Moip::sendMoip($data);
} catch (Exception $e) {
    echo $e->getMessage();
}
```

## Sending parameters

#### payer
----------------------
Send to MoIP data payer

```
$data['payer'] = [
    'payer'     => [
        'name'      => 'user name',
        'email'     => 'integracao@moip.com.br',
        'payerId'   => 'id_user',
        'identity'  => '111.111.111-11',
        'phone'     => '(11) 1111-1111)',
        'billingAddress' => [
            'address'   => 'Street Love',
            'number'    => 45,
            'complement'=> 'plaza',
            'city'      => 'São Paulo',
            'neighborhood' => 'Love',
            'state'     => 'SP',
            'country'   => 'BRA',
            'zipCode'   => '01230-000',
            'phone'     => '(11) 1 1111-1111)'
        ]
    ],    
];
```

#### values
----------------------
##### $full_price_products: Number, $freight: Number, $coupon: Number

1. $full_price_products: Responsible for setting the value that should be paid.
2. $freigth: Responsible for defining the additional amount to be paid.
3. $deduct: Responsible for defining the value of discount will be subtracted from the total to be paid.
```
$data['values'] = [
    'value'     => $full_price_products,
    'adds'      => $freigth,
    'dedudct'   => $deduct
];
```

#### unique_id
----------------------
##### $id: String

Its unique identifier request this same information will be sent to you on our notification of changes in status so that you can identify and treat your application status.

```
$data['unique_id'] = $id;
```

#### reason
----------------------
##### $value: String

Responsible for defining the reason for the payment

```
$data['reason'] = $value;
```

#### receiver
----------------------
##### $receiver String

Identifies the user who will receive payment in MoIP

```
$data['receiver'] = $receiver;
```

#### parcel
----------------------
##### $min: Number, $max: Number, $rate : Number, $transfer : Boolean

Responsible for the installment which will be available to the paying options.

1. $min : Minimum number of plots available to the paying.
2. $max : Maximum amount of shares available to the paying.
3. $rate : Amount of interest a.m per parcel.
4. $transfer : If `true` sets the default value of the interest will be paid by the paying MOIP.
```
$data['parcel'] = [
    'min'       => 2, 
    'max'       => 12, 
    'rate'      => 1.5, 
    'transfer'  => false
];
```

#### comission
----------------------
##### $reason: String, $receiver: String, $value: Number, $percentageValue: Boolean, $ratePayer: Boolean

1. $reason: Reason / Motif to which the secondary recipient will receive the set value.
2. $receiver: Login MOIP the User to receive the value.
3. $value: Value which will be allocated to the secondary receiver.
4. $percentageValue: If "true" sets that value will be calculated in relation to the percentage of
the total value of the transaction.
5. $ratepayer: If "true" sets that secondary recipient will pay the MOIP with
value received.

```
$data['comission'] = [ 
    'value' => 7, 
    'reason' => 'Taxa MoIP', 
    'ratePayer' => true, 
    'percentageValue' => true, 
    'receiver' => 'suporte@moip.com.br'
];
```

#### billet
----------------------
##### $expiration: Int ou Date, $workingDays: Boolean, $instructions: Array(), $uriLogo: String

1. $expiration: Date in "YYYY-MM-DD" format or number of days.
2. $workingDays: If "expiration" is the amount of days you can set to. "true" to that is counted in business days, the default is calendar days.
3. $instructions: Additional Message to be printed on the ticket, up to three messages.
4. $urlLogo: URL of your logo maximum dimensions 75px wide by 40px high.

```
$data['billet'] = [
    'billet' => [
        'expiration' => 3,
        'workingDays'=> true,
        'instructions' => [
            'firstLine' => 'First line of comment of billet'',
            'secondLine'=> 'Second line of comment of billet'',
            'lastLine'  => 'Last line of comment of billet'
        ],
        'urlLogo' => 'http://seutie.com.br/logo.png'
    ]
];
```

#### message
----------------------
##### $msg: String

1. $msg: Display additional messages at checkout MOIP to your buyer.

```
$data['message'] = [
    'firstLine' => 'comment of checkout'',
    'secondLine'=> 'comment of checkout'',
    'lastLine'  => 'comment of checkout'
];
```

#### returnURL
----------------------
##### $url : String

1. $url: responsible for defining the URL that the buyer will be redirected to finalize a payment through checkout MoIP

```
$data['returnURL'] = 'https://meusite.com.br/pedidofinalizado';
```

#### notificationURL
----------------------
##### $url : String

1. $url: responsible for defining the URL to which the MOIP shall notify to the NASP (Notification of Change in Status of Payment) the change of status.

```
$data['notificationURL'] = 'https://meusite.com.br/nasp';
```

#### payment
----------------------
##### $payment : String

1. $payment: Defines which forms of payment that will be displayed to the payer in Checkout MOIP
billet: To provide a "Billet Banking" as payment option at checkout.
financing: To enable the "Financing" as payment option at checkout.
debit: To provide the "Debit account" as a payment method at checkout.
creditCard: To provide a "Credit Card" as payment option in checkout.
debitCard: To provide a "Debit Card" as payment option in checkout.

```
$data['payment'] = [
    'creditCard'=> true,
    'billet'    => false,
    'financing' => false,
    'debit'     => false,
    'debitCard' => false
]
```

### Data Response

Method | Response
-------|----------
$moip->error | false or error message
$moip->response | true or false
$moip->token | token request
$moip->payment_url | payment url
$moip->xmlSend | xml sent
$moip->xmlGet | xml reponse
Moip::response() | object equal to all previous methods

### License

The MoIP pakacge is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
