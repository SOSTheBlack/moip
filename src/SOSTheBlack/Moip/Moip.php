<?php namespace SOSTheBlack\Moip;

use App;
use Config;
use StdClass;

/**
 * Moip's API abstraction class
 *
 * Class to use for all abstraction of Moip's API
 * 
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com>
 * @version v1.6.0
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
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
		$this->moip->setUniqueID( $data->unique_id);
		$this->getPayment($data->payment);
		$this->getParcel($data->parcel);
		$this->getComission($data->comission, $this->config);
		$this->getBilletConfig($data->billet);
		$this->getMessage($data->message);
		$this->getNotificationURL($data->notificationURL);
		$this->moip->setReturnURL($data->returnURL);
		$this->moip->setPayer($data->payer);
		$this->getReceiver($data);
		$this->getValidate();
		return $this->response($this->moip->send());
	}

	/**
	 * Method that sends data payment for the MoIP
	 * @param  object $payment forms of payment
	 * @return void
	 */
	private function getPayment($payment)
	{
		foreach ($payment as $key => $value) {
			if ($value === true) {
				$this->moip->addPaymentWay($key);
			}
		}
	}

	/**
	 * Method that sends data parcel for the MoIP
	 * @param object $parcel data of parcel
	 * @return void
	 */
	private function getParcel($parcel)
	{
		$this->moip->addParcel(
			$parcel->min, 
			$parcel->max, 
			$parcel->rate, 
			$parcel->transfer
		);
	}

	/**
	 * Method that sends data comission for the MoIP
	 * @param object $comission 
	 * @param object $config 
	 * @return void
	 */
	private function getComission($comission, $config)
	{
		if ($config->comission->active === true) {
			$this->moip->addComission(
				$comission->reason,
				$comission->receiver,
				$comission->value,
				$comission->percentageValue,
				$comission->ratePayer
			);
		}		
	}

	/**
	 * Method taht sends data billet for the MoIP
	 * @param  object $billet data of billet
	 * @return void         
	 */
	private function getBilletConfig($billet)
	{
		$this->moip->setBilletConf(
			$billet->expiration,
			$billet->workingDays,
			[
				$billet->instructions->firstLine,
				$billet->instructions->secondLine,
				$billet->instructions->lastLine
			],
			$billet->urlLogo
		);
	}

	/**
	 * Sends messages for ads in checkout MoIP
	 * @param  object $message Messges for ads
	 * @return void
	 */
	private function getMessage($message)
	{
		foreach ($message as $keyMessage => $valueMessage) {
			if (! empty($valueMessage)) {
				$this->moip->addMessage($valueMessage);
			}
		}		
	}

	/**
	 * Sends notification URL for MoIP
	 * 
	 * @param  string $notificationURL notification URL
	 * @return void
	 */
	private function getNotificationURL($notificationURL)
	{
		if (! empty($notificationURL)) {
			$this->moip->setNotificationURL($notificationURL);
		}
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
		$this->moip = App::make('\SOSTheBlack\Moip\Api');
		$this->config = $this->validatorConfig(Config::get('sostheblack::moip'));
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
