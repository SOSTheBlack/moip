# Moip (Laravel Package)

----------------------
This is a package of a payment intermediary called MOIP. 
Version 1.0 supports only the basic requirements and the necessary authentication to create the checkout

### Required setup

In the `require` key of `composer.json` file add the following

    "lararespect/moip": "dev-master"

Run the Composer update comand

    $ composer update

In your `config/app.php` add `'LaraRespect\Moip\ServiceProvider'` to the end of the `$providers` array

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'LaraRespect\Moip\ServiceProvider',

    ),

Then at the end of `config/app.php` add `'Moip'    => 'LaraRespect\Moip\Facade'` to the `$aliases` array

    'aliases' => array(

        'App'        => 'Illuminate\Support\Facades\App',
        'Artisan'    => 'Illuminate\Support\Facades\Artisan',
        ...
        'Moip'       => 'LaraRespect\Moip\Facade',

    ),

Copy the configuration file config/moip.php to app/config / folder. Law making that file changes it deems necessary.

### Method of delivery

Now you are ready to go:

    // Simply do
    Moip::sendMoip([
        'unique_id' => $sale_id,
        'value'     => $final_price,
        'reason'    => 'Virtual store, promoçao Children\'s Day',
    ]);

    // Or
    Moip::sendMoip([
        'value'     => $final_price
    ]);

### Method of response

    //token payment
    Moip::response()->token;
    //or when creating the payment
    Moip::sendMoip($data)->token;

    //payment url
    Moip::response()->payment_url;
    //or when creating the payment
    Moip::sendMoip($data)->payment_url;

    //xml sent
    Moip::response()->xmlSend;
    //or when creating the payment
    Moip::sendMoip($data)->xmlSend;

    //xml return
    Moip::response()->xmlGet;
    //or when creating the payment
    Moip::sendMoip($data)->xmlGet;