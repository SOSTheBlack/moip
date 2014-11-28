<?php namespace SOSTheBlack\Moip;

use App;
use DB;

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
		$this->initialize();
		$this->api->setUniqueID(false);
		$this->api->setValue('100.00');
		$this->api->setReason('Teste do Moip-PHP');
		$this->api->validate('Basic');
		$this->api->send();
		return $this->api->getAnswer();
	}
}