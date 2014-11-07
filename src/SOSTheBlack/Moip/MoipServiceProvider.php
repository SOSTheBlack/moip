<?php namespace SOSTheBlack\Moip;

use Illuminate\Support\ServiceProvider;
use View;
use Config;

class MoipServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('sostheblack/moip', 'sostheblack');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('moip', function(){
			return new \SOSTheBlack\Moip\Moip;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('sostheblack.moip', 'sostheblack.another-moip');
	}

}
