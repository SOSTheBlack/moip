<?php namespace SOSTheBlack\Moip;

use App;
use DB;

/**
* Moip's API abstraction class
*
* Class to use for all abstraction of Moip's API
*
* @author Jean Cesar Garcia <jeancesargarcia@gmail.com> <SOSTheBlack>
* @version 1.*
* @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
*/
class Moip
{
	/**
	 * Api of MoIP
	 *
	 * @var \SOSTheBlack\Moip\Api
	 **/
	private $api;

	/**
	 * data of configuration of the MoIP
	 *
	 * @var array moip
	 **/
	private $moip;

	/**
	 * Create order
	 * 
	 * @param string[] $order 
	 * @return \SOSTheBlack\Moip\Api\getAnswer
	 */
	public function postOrder(array $order)
	{
		$this->initialize()
			->setUniqueID(false)
			->setValue('100.00')
			->setReason('Teste do Moip-PHP')
			->validate('Basic')
			->send();
		return $this->api->getAnswer();
	}

	/**
	 * initialize()
	 * 
	 * @return \SOSTheBlack\Moip\Api
	 */
	private function initialize()
	{
		$this->moip = DB::table('moip')->first();
		$this->api 	= App::make('\SOSTheBlack\Moip\Api');
		$this->api->setEnvironment(! $this->moip->environment);
		$this->api->setCredential([
		    'key' 	=> $this->moip->key,
		    'token' => $this->moip->token
		]);
		return $this->api;
	}
}