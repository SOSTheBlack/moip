<?php namespace SOSTheBlack\Moip;

use App;

/**
* Moip's API abstraction class
*
* Class to use for all abstraction of Moip's API
*
* @author Jean Cesar Garcia <jeancesargarcia@gmail.com> <SOSTheBlack>
* @version 1.*
* @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
*/
class Moip
{

	/**
	 * Create order
	 * 
	 * @param type array $order 
	 * @return type
	 */
	public function postOrder(array $order)
	{
		$moip = App::make('\SOSTheBlack\Moip\Api');
		$moip->setEnvironment('test');
		$moip->setCredential(array(
		    'key' => 'ABABABABABABABABABABABABABABABABABABABAB',
		    'token' => '01010101010101010101010101010101'
		    ));
		$moip->setUniqueID(false);
		$moip->setValue('100.00');
		$moip->setReason('Teste do Moip-PHP');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
		$moip->validate('Basic');

		var_dump($moip->send());
		var_dump($moip->getAnswer());
	}
}