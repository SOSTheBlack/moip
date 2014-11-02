# MoIP (Laravel Package)
----------------------

[![Latest Stable Version](https://poser.pugx.org/sostheblack/moip/v/stable.svg)](https://packagist.org/packages/sostheblack/moip) [![Total Downloads](https://poser.pugx.org/sostheblack/moip/downloads.svg)](https://packagist.org/packages/sostheblack/moip) [![Latest Unstable Version](https://poser.pugx.org/sostheblack/moip/v/unstable.svg)](https://packagist.org/packages/sostheblack/moip) [![License](https://poser.pugx.org/sostheblack/moip/license.svg)](https://packagist.org/packages/sostheblack/moip)

Integrates via API, your e-commerce with MoIP quickly and easily

- `Moip::sendMoip($data);`
- `Moip::response`;

and response

- `public 'response' => true`
- `public 'error' => false`
- `public 'token' => 'J2E011C4K15150C2Y093Q5R0B0K1C2U7H4A0C070V0P0N0Y6W2X8G1T3M0R9'`
- `public 'payment_url' => do?token=J2E011C4K15150C2Y093Q5R0B0K1C2U7H4A0C070V0P0N0Y6W2X8G1T3M0R9'`
- `public 'xmlSend' => '<?xml version="1.0" encoding="utf-8"?>... </EnviarInstrucao>'`
- `public 'xmlGet' => '<ns1:EnviarInstrucaoUnicaResponse...</ns1:EnviarInstrucaoUnicaResponse>'`

## Instalation

### Laravel 4.2 and Blow

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `sostheblack/moip`.

soon in version v1.*

    "require-dev": {
        "sostheblack/moip": "1.*"
    }

Next, update Composer from the Terminal:

    $ composer update

Once that's been completed, the next step operation is to copy the file that is in moip.php `vendor/sostheblack/src/config/moip.php` and Paste in `app/config`

Make the necessary settings and proceed to the next step

Once this operation completes, the final step is to add the service provider and facade. Open `app/config/app.php`.

Add a new item to the providers array.

    'providers' => array(
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'SOSTheBlack\Moip\ServiceProvider',
    ),

Add a new item to the facades array.

    'aliases' => array(
        'App'        => 'Illuminate\Support\Facades\App',
        'Artisan'    => 'Illuminate\Support\Facades\Artisan',
        ...
        'Moip'       => 'SOSTheBlack\Moip\Facade',
    ),

## Usage

### simple

Sent only the total sale, is configured to send data in `app/config/moip.php`

    $data = ['values' => ['value' => $full_price_products] ];
    try {
        $moip = Moip::sendMoip($data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

### Advanced

Fully customize the data sent!

    $data = [
        'unique_id' => 100000001,
        'reason'    => 'market of Natal 01',
        'receiver'  => 'jean@comunicaweb.com.br',
        'parcel'    => ['min' => 2, 'max' => 12, 'rate' => 1.5, 'transfer' => true],
        'values'    => ['value' => $full_price_products , 'adds' => $freight, 'deduct'=> $coupon],
    ];
    try {
        $moip = Moip::sendMoip($data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

## Sending parameters

#### values
##### $full_price_products: Number, $freight: Number, $coupon: Number

1. $full_price_products: Responsible for setting the value that should be paid.
2. $freigth: Responsible for defining the additional amount to be paid.
3. $deduct: Responsible for defining the value of discount will be subtracted from the total to be paid.


    $data['values'] => [
        'value'     => $full_price_products,
        'adds'      => $freigth,
        'dedudct'   => $deduct
    ];

#### unique_id
##### $id: String

Its unique identifier request this same information will be sent to you on our notification of changes in status so that you can identify and treat your application status.

    $data['unique_id'] = $id;

#### reason
##### $value: String

Responsible for defining the reason for the payment

    $data['reason'] => $value;

#### receiver
##### $receiver String

Identifies the user who will receive payment in MoIP

    $data['receiver'] = $receiver

#### parcel
##### $min: Number, $max: Number, $rate : Number, $transfer : Boolean

Responsible for the installment which will be available to the paying options.

1. $min : Minimum number of plots available to the paying.
2. $max : Maximum amount of shares available to the paying.
3. $rate : Amount of interest a.m per parcel.
4. $transfer : If `true` sets the default value of the interest will be paid by the paying MOIP.


    $data['parcel'] => [
        'min'       => 2, 
        'max'       => 12, 
        'rate'      => 1.5, 
        'transfer'  => false
    ];

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
