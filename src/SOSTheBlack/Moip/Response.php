<?php namespace SOSTheBlack\Moip;

/**
 * Read-only response
 * @property boolean|string $response
 * @property string $error
 * @property string $xml
 * @property string $payment_url
 * @property string $token
 */
class Response {

	/**
	 * [$response description]
	 * @var [type]
	 */
	private $response;

	/**
	 * Description
	 * @param type array $response 
	 * @return type
	 */
	function __construct(array $response)
	{
		$this->response = $response;
	}

	/**
	 * Description
	 * @param type $name 
	 * @return type
	 */
	function __get($name)
	{
		if (isset($this->response[$name]))
		{
			return $this->response[$name];
		}
		return null;
	}
}