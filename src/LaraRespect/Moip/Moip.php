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

	function __construct() {
		$this->setConfig(Config::get('moips'));
	}

	private function initialize()
	{
		$this->setConfig(Config::get('moips'));
	}

	private function getConfig()
	{
		return $this->config;
	}

	private function setConfig(array $config)
	{
		return $this->config($config);
	}
}