<?php namespace LaraRespect\Moip;

use Config;
use StdClass;

class Moip extends Validator 
{
	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	private $moip;

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	private $config;

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	private $response;

	public function sendMoip($data)
	{
		$this->initialize();
		$data = (object) $data;
		$this->validatorData($data, $this->config);
		
		if ($this->validatorValidate($this->config->validate) === 'Basic') {
			$this->moip->setUniqueID($data->unique_id);
			$this->moip->setValue($data->value);
			$this->moip->setReason($data->reason);
		}

		$this->getValidate();
		return $this->response($this->moip->send());
	}

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
	private function initialize()
	{
		$this->moip = new Api;
		$this->config = $this->validatorConfig(Config::get('moip'));
		$this->getEnvironment();
		$this->authentication();
	}

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

	private function getValidate()
	{
		$this->moip->validate($this->validatorValidate($this->config->validate));
		return $this;
	}

	private function getEnvironment()
	{
		return $this->moip->setEnvironment($this->config->environment);;
	}
}
