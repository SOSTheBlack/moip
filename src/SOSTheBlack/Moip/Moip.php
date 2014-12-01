<?php namespace SOSTheBlack\Moip;

/**
 * Moip's API abstraction class
 *
 * Class to use for all abstraction of Moip's API
 * @package SOSTheBlack\Moip
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com> <SOSTheBlack>
 * @version 1.*
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 **/
class Moip extends MoipAbstract implements MoipInterface
{
	/**
	 * Create order
	 * 
	 * @param string[] $order 
	 * @return \SOSTheBlack\Moip\Api\getAnswer
	 */
	public function postOrder(array $order)
	{
		$this->setData($order);
		$this->initialize();
		$this->api->setUniqueID($this->getUniqueId());
		$this->api->setValue($this->data['prices']['value']);
		$this->api->setAdds($this->getParams('prices', 'adds'));
		$this->api->setDeduct($this->getParams('prices','deduct'));
		$this->api->setReason($this->getReason());
		$this->getPaymentWay();
		$this->api->validate($this->getValidate());
		$this->api->send();
		return $this->api->getAnswer();
	}

	/**
	 * getXML 
	 * 
	 * return the generated XML with all the attributes you set
	 * 
	 * @return string
	 */
	public function getXML()
	{
		return $this->api->getXML();
	}
}