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
	 * Data wil be sent to MoIP
	 *
	 * @var string
	 **/
	private $data;

	/**
	 * Method that sends data to Moip and creates op chekout
	 * @param array or object $data
	 * @return response moip
	 */
	public function sendMoip( array $data)
	{
		$data = $this->initialize($data);
		$this->validatorSend($data, $this->config);
		$this->moip->setReason($data->reason);
		$this->moip->setValue($data->values->value);
		$this->moip->setAdds($data->values->adds);
		$this->moip->setDeduct($data->values->deduct);
		$this->moip->setUniqueID($data->unique_id);
		if ($this->config->parcel->active === true) {
			$this->moip->addParcel(
				$data->parcel->min, 
				$data->parcel->max, 
				$data->parcel->rate, 
				$data->parcel->transfer
			);
		}
		if ($this->config->comission->active === true) {
			$this->moip->addComission(
				$data->comission->reason,
				$data->comission->receiver,
				$data->comission->value,
				$data->comission->percentageValue,
				$data->comission->ratePayer
			);
		}
		$this->moip->setBilletConf(
			$data->billet->expiration,
			$data->billet->workingDays,
			[
				$data->billet->instructions->firstLine,
				$data->billet->instructions->secondLine,
				$data->billet->instructions->lastLine
			],
			$data->billet->urlLogo
		);
		if (! empty($data->message->firstLine)) {
			$this->moip->addMessage($data->message->firstLine);	
		}
		if (! empty($data->message->secondLine)) {
			$this->moip->addMessage($data->message->secondLine);	
		}
		if (! empty($data->message->lastLine)) {
			$this->moip->addMessage($data->message->lastLine);	
		}

		$this->moip->setReturnURL($data->returnURL);
		
		$this->getReceiver($data);
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

	/**
	 * Checks if the recipient sends login MoIP
	 * @param  object $data 
	 * @return $this
	 */
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
		if ($this->validatorCredential($this->config->credentials) === true) {
			$this->moip->setCredential([
				'key'	=> $this->config->credentials->key,
				'token' => $this->config->credentials->token,
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
