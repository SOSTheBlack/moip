<?php namespace SOSTheBlack\Moip;

use Config;
use StdClass;

/**
 * Moip's API abstraction class
 *
 * Class to use for all abstraction of Moip's API
 */
class Moip extends Validator
{
	/**
	 * Use for all abstraction of Moip's API
	 *
	 * @var new Api
	 **/
	private $moip;

	/**
	 * Settings required for integration
	 *
	 * @var object
	 **/
	private $config;

	/**
	 * Response
	 *
	 * @var object
	 **/
	private $response;

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	private $data;

	/**
	 * Method that sends data to Moip and creates op chekout
	 * @param array or object $data
	 * @return response moip
	 */
	public function sendMoip($data)
	{
		$data = $this->initialize($data);
		$this->validatorSend($data, $this->config);

		// Razão
		$this->moip->setReason($data->reason);

		// // Value
		$this->moip->setValue($data->values->value);
		$this->moip->setAdds($data->values->adds);
		$this->moip->setDeduct($data->values->deduct);

		$this->moip->setUniqueID($data->unique_id);

		// // Parcel
		// $this->moip->addParcel($min, $max, $am, $transfer);

		// // Comission
		// $this->moip->addComission($reason, $receiver, $value, $percentageValue, $ratePayer);

		// Receiver
		$this->getReceiver($data);

		// // Payer - Array ('name','email','payerId','identity', 'phone','billingAddress' =>
		// // 	Array('address','number','complement','city','neighborhood','state','country','zipCode','phone'))
		// $this->moip->setPayer($array);

		// // Payment - 'billet','financing','debit','creditCard','debitCard'
		// $moip->addPaymentWay('creditCard');

		// // Boleto
		// $this->moip->setBilletConf($expiration, $workingDays, $instructions, $uriLogo);
		// $this->moip->addMessage($msg);

		// // URL de retorno do pagado
		// $this->moip->setReturnURL($url);

		// // URL de envio do NASP
		// $this->moip->setNotificationURL($url);

		$this->getValidate();
		return $this->response($this->moip->send());
	}

	/**
	 * Method that returns an object with the token request,
	 * link, sending XML and XML return
	 * @param  object $send Return of sendMoip method
	 * @return object token request, link, sending XML
	 * and XML return
	 */
	public function response($send = '')
	{
		if (! empty($send)) {
			$answer = $this->moip->getAnswer();
			$this->validatorResponseError($answer->error);
			$this->response = new StdClass;
			$this->response->response 	 = $answer->response;
			$this->response->error 		 = $answer->error;
			$this->response->token 		 = $answer->token;
			$this->response->payment_url = $answer->payment_url;
			$this->response->xmlSend 	 = $this->moip->getXML();
			$this->response->xmlGet  	 = $send->xml;
		}

		return $this->response;
	}

	private function getReceiver($data)
	{
		if (! empty($data->receiver)) {
			$this->moip->setReceiver($data->receiver);
		}

		return $this;
	}	

	/**
	 * Method required to start integration.
	 * Authentication and environment that the request will be sent
	 * @return object \SOSTheBlack\Moip\Validator
	 */
	private function initialize($data)
	{
		$this->moip = new Api;
		$this->config = $this->validatorConfig(Config::get('moip'));
		$this->getEnvironment();
		$this->authentication();
		return $this->validatorData($data);
	}

	/**
	 * Authentication credentials and key token
	 * @return $this
	 */
	private function authentication()
	{
		if ($this->validatorCredential($this->config) === true) {
			$this->moip->setCredential([
				'key'	=> $this->config->key,
				'token' => $this->config->token,
			]);
		}
		return $this;
	}

	/**
	 * Validation to determine whether the data sent will be basic,
	 * or for identifying user
	 * @return $this
	 */
	private function getValidate()
	{
		$this->moip->validate($this->validatorValidate($this->config->validate));
		return $this;
	}

	/**
	 * Which validation environment for the requisition is sent MOIP
	 * Development environment and Production environment
	 * @return $this
	 */
	private function getEnvironment()
	{
		return $this->moip->setEnvironment($this->config->environment);;
	}
}
