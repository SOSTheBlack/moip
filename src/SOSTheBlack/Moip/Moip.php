<?php namespace SOSTheBlack\Moip;

use Config;
use StdClass;

/**
 * Moip's API abstraction class
 *
 * Class to use for all abstraction of Moip's API
 */
class Moip extends Validator 
{
	/**
	 * Use for all abstraction of Moip's API
	 *
	 * @var new Api 
	 **/
	private $moip;

	/**
	 * Settings required for integration
	 *
	 * @var object
	 **/
	private $config;

	/**
	 * Response
	 *
	 * @var object
	 **/
	private $response;

	/**
	 * Method that sends data to Moip and creates op chekout
	 * @param array or object $data 
	 * @return response moip
	 */
	public function sendMoip($data)
	{
		if (! is_object($data)) {
			$data = (object) $data;
		}
		
		$this->initialize();
		$this->validatorData($data, $this->config);
		
		if ($this->validatorValidate($this->config->validate) === 'Basic') {
			$this->moip->setUniqueID($data->unique_id);
			$this->moip->setValue($data->value);
			$this->moip->setReason($data->reason);
		}

		$this->getValidate();
		return $this->response($this->moip->send());
	}

	/**
	 * Method that returns an object with the token request, 
	 * link, sending XML and XML return
	 * @param  object $send Return of sendMoip method
	 * @return object token request, link, sending XML 
	 * and XML return
	 */
	public function response($send = '')
	{
		if (! empty($send)) {
			$answer = $this->moip->getAnswer();
			$this->response = new StdClass;
			$this->response->token = $answer->token;
			$this->response->payment_url = $answer->payment_url;
			$this->response->xmlSend = $this->moip->getXML();
			$this->response->xmlGet  = $send->xml;
		}
		return $this->response;
	}

	/**
	 * Method required to start integration. 
	 * Authentication and environment that the request will be sent
	 * @return null
	 */
	private function initialize()
	{
		$this->moip = new Api;
		$this->config = $this->validatorConfig(Config::get('moip'));
		$this->getEnvironment();
		$this->authentication();
	}

	/**
	 * Authentication credentials and key token
	 * @return $this
	 */
	private function authentication()
	{
		if ($this->validatorCredential($this->config) === true) {
			$this->moip->setCredential([
				'key'	=> $this->config->key,
				'token' => $this->config->token,
			]);
		}
		return $this;
	}

	/**
	 * Validation to determine whether the data sent will be basic, 
	 * or for identifying user
	 * @return $this
	 */
	private function getValidate()
	{
		$this->moip->validate($this->validatorValidate($this->config->validate));
		return $this;
	}

	/**
	 * Which validation environment for the requisition is sent MOIP
	 * Development environment and Production environment
	 * @return $this
	 */
	private function getEnvironment()
	{
		return $this->moip->setEnvironment($this->config->environment);;
	}
}
