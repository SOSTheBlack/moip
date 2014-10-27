<?php namespace SOSTheBlack\Moip;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Config;

class ServiceProvider extends BaseServiceProvider
{
	public function register()
	{		
		$this->app->singleton('moip', function(){
			return new \SOSTheBlack\Moip\Moip;
		});
	}
}