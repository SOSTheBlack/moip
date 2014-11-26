<?php namespace SOSTheBlack\Moip;

class Environment {
	/**
	 * [$base_url description]
	 * @var [type]
	 */
	public $base_url;

	/**
	 * [$name description]
	 * @var [type]
	 */
	public $name;

	/**
	 * Description
	 * @param type $base_url 
	 * @param type $name 
	 * @return type
	 */
	function __construct($base_url = '', $name = '')
	{
		$this->base_url = $base_url;
		$this->name = $name;
	}
}