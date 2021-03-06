<?php namespace SOSTheBlack\Moip;

use Illuminate\Support\ServiceProvider;

/**
 * Moip Service Provider
 * 
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com>
 * @version v1.6.0
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 */
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
		$this->commands('\SOSTheBlack\Moip\Commands\MoipAssetsCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipAuthCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipBilletCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipConfigCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipCreditCardCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipDebitCardCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipFinancingCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipInstallCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipMigrateCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipPaymentCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipReasonCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipReceiverCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipSeedsCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipUrlReturnCommand');
		$this->commands('\SOSTheBlack\Moip\Commands\MoipUrlNotificationCommand');
		$path = $this->guessPackagePath();
        require_once $path.'/routes.php';
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

		$this->app->singleton('controller', function(){
			return new \SOSTheBlack\Moip\Controllers\MoipController;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 */
	public function provides()
	{
		return array('sostheblack.moip', 'sostheblack.another-moip');
	}

}
