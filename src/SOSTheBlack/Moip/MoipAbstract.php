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
	 * undocumented class variable
	 *
	 * @var string
	 **/
	protected $data;

	/**
	* initialize()
	*
	* @return \SOSTheBlack\Moip\Api
	*/
	protected function initialize()
	{
		$this->moip = DB::table('moip')->first();
		$this->api  = App::make('\SOSTheBlack\Moip\Api');
		$this->api->setEnvironment(! $this->moip->environment);
		$this->api->setCredential([
		    'key' 	=> $this->moip->key,
		    'token' => $this->moip->token
		]);
		return $this->api;
	}

	/**
	 * setData()
	 * 
	 * @param string[] $data
	 * @return void
	 */
	protected function setData($data)
	{
		$this->data = $data;
	}	

	/**
	 * getValidate()
	 * 
	 * @return boolean
	 */
	protected function getValidate()
	{
		return $this->moip->validate === 0 ? 'Basic' : 'Identification';
	}

	/**
	 * getUniqueId()
	 * 
	 * @return boolean|string
	 */
	protected function getUniqueId()
	{
		return isset($this->data['unique_id']) ? $this->data['unique_id'] : false;
	}

	/**
	 * getReason()
	 * 
	 * @return string
	 */
	protected function getReason()
	{
		return isset($this->data['reason']) ? $this->data['reason'] : $this->moip->reason;
	}
}