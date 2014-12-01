<?php namespace SOSTheBlack\Moip;

use App;
use Exception;

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
	 * undocumented class variable
	 *
	 * @var string
	 **/
	private $response;

	/**
	 * postOrder
	 * 
	 * @param string[] $order 
	 * @return \SOSTheBlack\Moip\Moip\response
	 */
	public function postOrder(array $order)
	{
		$this->setData($order);
		$this->initialize();
		$this->api->setUniqueID($this->getUniqueId());
		$this->api->setValue($this->data['prices']['value']);
		$this->api->setBilletConf(
			$this->getParams('billet', 'expiration', true),
			(boolean) $this->getParams('billet', 'workingDays', true),
			$this->getBilletInstructions(),
			$this->getParams('billet', 'uriLogo', true)
		);
		$this->api->setAdds($this->getParams('prices', 'adds'));
		$this->api->setDeduct($this->getParams('prices','deduct'));
		$this->api->setReason($this->getReason());
		$this->getPaymentWay();
		$this->api->validate($this->getValidate());
		return $this->response($this->api->send());
	}

	/**
	 * response
	 * 
	 * @param type $send 
	 * @return string[]|Exception
	 */
	public function response($send = null)
	{
		if ($send) {
			if ($send->error != false) {
				throw new Exception($send->error);
			}

			$answer 					= $this->api->getAnswer();
			$this->response 			= App::make('stdClass');
			$this->response->getXML 	= $this->api->getXML();
			$this->response->replyXML 	= $send->xml;
			$this->response->token 		= $answer->token;
			$this->response->url 		= $answer->payment_url;
		}
		
		return $this->response;
	}
}