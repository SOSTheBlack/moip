<?php namespace SOSTheBlack\Moip;

/**
 * MoipInterface
 *
 * @package SOSTheBlack\Moip
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com> <SOSTheBlack>
 * @version 1.*
 **/
interface MoipInterface
{
	/**
	 * postOrder
	 * 
	 * @param string[] $order 
	 * @return \SOSTheBlack\Moip\Moip\response
	 */
	public function postOrder(array $order);

	/**
	 * response 
	 * 
	 * @param type $send 
	 * @return string[]|Exception
	 */
	public function response($send = null);
}