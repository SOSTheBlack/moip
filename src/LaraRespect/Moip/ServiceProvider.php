<?php namespace LaraRespect\Moip;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Config;

class ServiceProvider extends BaseServiceProvider
{
	public function register()
	{		
		$this->app->singleton('moip', function(){
			return new \LaraRespect\Moip\Moip(Config::get('moip'));
		});		
	}
}