<?php namespace SOSTheBlack\Moip;

use App;
use DB;

/**
 * MoipAbstract
 *
 * @package SOSTheBlack\Moip
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com> <SOSTheBlack>
 * @version 1.*
 **/
abstract class MoipAbstract
{
	/**
	 * Api of MoIP
	 *
	 * @var \SOSTheBlack\Moip\Api
	 **/
	protected $api;

	/**
	 * data of configuration of the MoIP
	 *
	 * @var array table moip
	 **/
	protected $moip;

	/**
	 * initialize()
	 * 
	 * @return \SOSTheBlack\Moip\Api
	 */
	protected function initialize()
	{
		$this->api  = App::make('\SOSTheBlack\Moip\Api');
		$this->moip = DB::table('moip')->first();
		$this->api->setEnvironment(! $this->moip->environment);
		$this->api->setCredential([
		    'key' 	=> $this->moip->key,
		    'token' => $this->moip->token
		]);
		return $this->api;
	}
}