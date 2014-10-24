<?php namespace LaraRespect\Moip;

class Moip extends Validator 
{
	public function __construct($config) 
	{
		$this->config = $this->validatorConfig($config);
	}

	public function sendMoip()
	{
		return 'Hellow Word...';
	}

	private function initialize()
	{
		$this->getEnvironment()->authentication()->getValidate();
	}

	private function authentication()
	{
		$this->setCredential($this->validatorCredential($this->config));
		return $this;
	}

	private function getValidate()
	{
		$this->validate($this->validatorValidade($this->config->validate));
		return $this;
	}

	private function getEnvironment()
	{
		if ($this->config->environment === true) 
			$this->setEnvironment(true);
		$this;
	}
}