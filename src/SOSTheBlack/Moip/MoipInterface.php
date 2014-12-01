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
	 * Create order
	 * 
	 * @param string[] $order 
	 * @return \SOSTheBlack\Moip\Api\getAnswer
	 */
	public function postOrder(array $order);

	/**
	 * getXML 
	 * 
	 * return the generated XML with all the attributes you set
	 * 
	 * @return string
	 */
	public function getXML();
}