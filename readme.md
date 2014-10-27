# Moip (Laravel Package)
----------------------

[![Latest Stable Version](https://poser.pugx.org/SOSTheBlack/moip/v/stable.svg)](https://packagist.org/packages/SOSTheBlack/moip) [![Total Downloads](https://poser.pugx.org/SOSTheBlack/moip/downloads.svg)](https://packagist.org/packages/SOSTheBlack/moip) [![Latest Unstable Version](https://poser.pugx.org/SOSTheBlack/moip/v/unstable.svg)](https://packagist.org/packages/SOSTheBlack/moip) [![License](https://poser.pugx.org/SOSTheBlack/moip/license.svg)](https://packagist.org/packages/SOSTheBlack/moip)

This is a package of a payment intermediary called MOIP. 
Version 1.0 supports only the basic requirements and the necessary authentication to create the checkout

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

Copy the configuration file config/moip.php to app/config / folder. Law making that file changes it deems necessary.

### Method of delivery

Now you are ready to go:

Simply do
    Moip::sendMoip([
        'unique_id' => $sale_id,
        'value'     => $final_price,
        'reason'    => 'Virtual store, promoçao Children\'s Day',
    ]);

Or
    Moip::sendMoip([
        'value'     => $final_price
    ]);
or even try block
    try {
        Moip::sendMoip($data);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

### Method of response

    //token payment
    Moip::response()->token;
    Moip::sendMoip($data)->token;

    //payment url
    Moip::response()->payment_url;
    Moip::sendMoip($data)->payment_url;

    //xml sent
    Moip::response()->xmlSend;
    Moip::sendMoip($data)->xmlSend;

    //xml return
    Moip::response()->xmlGet;
    Moip::sendMoip($data)->xmlGet;
