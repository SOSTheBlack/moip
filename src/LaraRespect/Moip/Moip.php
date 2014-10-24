<?php namespace LaraRespect\Moip;

use Config;

class Moip extends Validator
{
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
	private $moip;

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	private $validator;

	function __construct() {
		$this->initialize();
	}

	private function initialize()
	{
		$this->config = (object) $this->validatorConfig(Config::get('moip'));
		$this->moip = new Api;
		$this->validator = new Validator;
		$this->getEnvironment();
		$this->authentication();
		$this->getValidate();	
	}

	public function sendMoip($data)
	{
		$this->initialize();
	}

	private function authentication()
	{
		return $this->moip->setCredential($this->validatorCredential($this->config));
	}

	private function getValidate()
	{
		return $this->moip->validate($this->validatorValidade($this->config->validate));	
	}

	private function getEnvironment()
	{
		if ($this->config->environment === true) {
			return $this->moip->setEnvironment(true);
		} else {
			return false;
		}
	}
}