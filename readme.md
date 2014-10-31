# MoIP (Laravel Package)
----------------------

[![Latest Stable Version](https://poser.pugx.org/sostheblack/moip/v/stable.svg)](https://packagist.org/packages/sostheblack/moip) [![Total Downloads](https://poser.pugx.org/sostheblack/moip/downloads.svg)](https://packagist.org/packages/sostheblack/moip) [![Latest Unstable Version](https://poser.pugx.org/sostheblack/moip/v/unstable.svg)](https://packagist.org/packages/sostheblack/moip) [![License](https://poser.pugx.org/sostheblack/moip/license.svg)](https://packagist.org/packages/sostheblack/moip)

This is a package of a payment intermediary called MOIP.

### Required setup

In the `require` key of `composer.json` file add the following

    "SOSTheBlack/moip": "dev-master"

Run the Composer update comand

    $ composer update

In your `config/app.php` add `'SOSTheBlack\Moip\ServiceProvider'` to the end of the `$providers` array

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'SOSTheBlack\Moip\ServiceProvider',

    ),

Then at the end of `config/app.php` add `'Moip'    => 'SOSTheBlack\Moip\Facade'` to the `$aliases` array

    'aliases' => array(

        'App'        => 'Illuminate\Support\Facades\App',
        'Artisan'    => 'Illuminate\Support\Facades\Artisan',
        ...
        'Moip'       => 'SOSTheBlack\Moip\Facade',

    ),

Copy the configuration file config/moip.php to app/config folder. Law making that file changes it deems necessary.

### sending data for create chackout page

Now you are ready to go:

Riding array:
    
    $data = [
        'unique_id' => $id_buy,
        'reason'    => 'Promotion of rule markup 01',
        'values'    => ['value' => $full_price_products , 'adds' => $freight, 'deduct'=> $discount],
        'receiver'  => 'jeancesargarcia@gmail.com'
    ];

Creating the checkout page:

    try {
        $moip = Moip::sendMoip($data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

### Data Response

Method | Response
-------|---------
$moip->error | false or error message
$moip->response | true or false
$moip->token | token request
$moip->payment_url | payment url
$moip->xmlSend | xml sent
$moip->xmlGet | xml reponse
