<?php namespace SOSTheBlack\Moip;

use UnexpectedValueException;
use InvalidArgumentException;
use LengthException;
use LogicException;
use Exception;

/**
 * Class to validate all data Moip
 * 
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com>
 * @version v1.6.0
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 */
class Validator
{
	/**
	 * Validate the data for using in class Moip
	 * @param  array or data $data data for new checkout
	 * @return object data
	 */
	protected function validatorData($data)
	{
		$data = (object) $data;
		$data->values 	 = $this->toObject($data, 'values', true);
		$data->parcel 	 = $this->toObject($data, 'parcel');
		$data->comission = $this->toObject($data, 'comission');
		$data->billet	 = $this->toObject($data, 'billet');
		$data->billet->instructions = $this->toObject($data->billet, 'instructions') ;
		$data->message 	 = $this->toObject($data, 'message');
		$data->payment	 = $this->toObject($data, 'payment');
		$data->payer 	 = $this->toObject($data, 'payer');
		$data->payer->billingAddress = $this->toObject($data->payer, 'billingAddress');
		return $data;
	}

	/**
	 * Verifies the existence of the configuration file Moip
	 * @param  array $config Moip the configuration
	 * @return object        Moip the configuration
	 */
	protected function validatorConfig($config)
	{
		if (empty($config)) {
			throw new InvalidArgumentException("Arquivo de configuração moip não foi encontrado", 1);
		} else {
			$config 				= (object) $config;
			$config->credentials 	= $this->toObject($config, 'credentials', true);
			$config->parcel 		= $this->toObject($config, 'parcel', true);
			$config->comission 		= $this->toObject($config, 'comission', true);
			$config->billet 		= $this->toObject($config, 'billet');
			$config->billet->instructions = $this->toObject($config->billet, 'instructions');
			$config->message 		= $this->toObject($config, 'message');
			$config->payment 		= $this->toObject($config, 'payment');
			return $config;
		}
	}

	/**
	 * Validates the data sent by the user
	 * @param  object $data   user data
	 * @param  object $config config Moip
	 * @return void
	 */
	protected function validatorSend($data, $config)
	{
		if ($this->validatorValidate($config->validate) === 'Identification') {
			$this->validatorIdentification($data, $config);
			$this->validatorPayer($data->payer);
		} else {
			$this->validatorBasic($data, $config);
		}
		$this->validatorUniqueID($data);
		$this->validatorValues($data->values);
		$this->validatorReceiver($data, $config);
		$this->validatorParcel($data, $config);
 		$this->validatorComission($data, $config);
 		$this->validatorBillet($data, $config);
 		$this->validatorMessage($data, $config);
 		$this->validatorReturnURL($data, $config);
 		$this->validatorNotificationURL($data, $config);
 		$this->validatorPayment($data, $config);
	}


	/**
	 * Convert array to object
	 * @param array $data 
	 * @param string $value 
	 * @param boolean $required 
	 * @return object $data
	 */
	private function toObject($data, $value = '', $required = false)
	{
		if (empty($value) && is_array($data)) {
			return (object) $data;
		} else {
			if (! isset($data->$value) && $required === true) {
				throw new LogicException("É obrigatório enviar ". $value, 1);
			} elseif (! isset($data->$value) && $required === false) {
				return (object) $data->$value = new \stdClass();
			} else {
				return (object) $data->$value;
			}
		}
	}

	/**
	 * Validation for the parameter unqiue_id
	 * @return void
	 */
	private function validatorUniqueID($data)
	{
		if (isset($data->unique_id)) {
			if (! ctype_alnum($data->unique_id) && ! is_bool($data->unique_id) ) {
				throw new UnexpectedValueException("data->unique_id deve ser alfanumárico");
			}
		} else {
			$data->unique_id = false;
		}		
	}

	/**
	 * Validation for the parameter values ( prices )
	 * @param  object $values prices of request
	 * @return void
	 */
	private function validatorValues($values)
	{
		if (! isset($values->adds)) {
			$values->adds = 0.0;
		} elseif (! is_numeric($values->adds)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($values->deduct) . ", esperava-se float");
		}

		if (! isset($values->deduct)) {
			$values->deduct = 0.0;
		} elseif (! is_numeric($values->deduct)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($values->deduct) . ", esperava-se float");
		}
	}


	/**
	 * Validation for the receiver
	 * @param  object $data   data sent
	 * @param  object $config configured data
	 * @return data
	 */
	private function validatorReceiver($data, $config)
	{
		if (! isset($data->receiver)) {
			if (! isset($config->receiver)) {
				throw new InvalidArgumentException("Não foi encontrado o parametro receiver no arquivo de configuração moip.php");
			} else {
				$data->receiver = $config->receiver;
			}
		}

		if (strlen($data->receiver) > 65) {
			throw new LengthException("receiver não pode conter mais de 65 caracteres");
		}
	}

	/**
	 * Validator for the payment 
	 * @param  object $data   data sent
	 * @param  object $config configured data
	 * @return void
	 */
	private function validatorPayment($data, $config)
	{
		$data->payment = $this->getParams($data, $config, 'payment');
		$data->payment->creditCard = $this->getParams($data, $config, 'payment', 'creditCard');
		$data->payment->billet = $this->getParams($data, $config, 'payment', 'billet');
		$data->payment->financing = $this->getParams($data, $config, 'payment', 'financing');
		$data->payment->debit = $this->getParams($data, $config, 'payment', 'debit');
		$data->payment->debitCard = $this->getParams($data, $config, 'payment', 'debitCard');
		foreach ($data->payment as $key => $value) {
			if (! is_bool($value)) {
				throw new UnexpectedValueException("$key passado é do tipo ". gettype($key) . ", esperava-se boolean");
			}
		}
	}

	/**
	 * Validation fot the notification URL
	 * @param  object $data   data sent
	 * @param  object $config configured data
	 * @return void
	 */
	private function validatorNotificationURL($data, $config)
	{
		$data->notificationURL = (string) $this->getParams($data, $config, 'notificationURL');
		if (strlen($data->notificationURL) > 256) {
			throw new InvalidArgumentException("URL de notificação não devem conter mais de 256 caracteres");	
		}
	}

	/**
	 * validation for the return URL
	 * @param  object $data   data sent
	 * @param  object $config configured data
	 * @return void
	 */
	private function validatorReturnURL($data, $config)
	{
		$data->returnURL = (string) $this->getParams($data, $config, 'returnURL');
		if (strlen($data->returnURL) > 256) {
			throw new InvalidArgumentException("URL de retorno não devem conter mais de 256 caracteres");	
		}
	}

	/**
	 * Validation for the message
	 * @param  object $data   data sent
	 * @param  object $config configured data
	 * @return void
	 */
	private function validatorMessage($data, $config)
	{
 		$data->message 				= $this->getParams($data, $config, 'message');
 		$data->message->firstLine	= (string) $this->getParams($data, $config, 'message', 'firstLine');
 		$data->message->secondLine	= (string) $this->getParams($data, $config, 'message', 'secondLine');
 		$data->message->lastLine	= (string) $this->getParams($data, $config, 'message', 'lastLine');
		if (strlen($data->message->firstLine) > 256 || strlen($data->message->secondLine) > 256 || strlen($data->message->firstLine > 256)) {
			throw new InvalidArgumentException("Menssagens do checkout não devem conter mais de 256 caracteres");	
		}		
	}

	/**
	 * Validation for data of payer
	 * @param  object $payer  data of payer
	 * @return void
	 */
	private function validatorPayer($payer)
	{
		$payerArray = [
			'name'  => ''    ,
	        'email'  => ''   ,
	        'payerId'  => '' ,
	        'identity' => '',
	        'phone' => '',
	        'billingAddress' => [
	            'address'  => '' ,
	            'number'   => '' ,
	            'complement'=> '',
	            'city'   => ''   ,
	            'neighborhood'=> '' ,
	            'state'    => '' ,
	            'country'  => '' ,
	            'zipCode'  => '' ,
	            'phone'   => ''  
	        ]
		];
		if (empty($payer->billingAddress)) {
			throw new InvalidArgumentException("é obrigatório informar os todos os dados para pagador");	
		} else {
			foreach ($payerArray as $keyPayerArray => $valuePayerArray) {
				if (array_key_exists($keyPayerArray, $payer) === false) {
					throw new InvalidArgumentException("é obrigatório informar $keyPayerArray do pagador");		
				}
				if (empty($payer->$keyPayerArray)) {
					throw new InvalidArgumentException($keyPayerArray . " não pode estar vazio");
				}

				if ($keyPayerArray === 'billingAddress') {
					foreach ($payerArray['billingAddress'] as $keyBillingAddress => $valueBillingAddress) {
						if (array_key_exists($keyBillingAddress, $payer->billingAddress) === false) {
							throw new InvalidArgumentException("é obrigatório informar $keyBillingAddress do pagador");		
						}
						if (empty($payer->billingAddress->$keyBillingAddress)) {
							throw new InvalidArgumentException($keyBillingAddress . " não pode estar vazio");
						}

						if ($keyBillingAddress === 'state' && strlen($payer->billingAddress->state) > 2 ) {
							throw new InvalidArgumentException("Estado deve estar no formado ISO-CODE(2)");
						}
					}
				}
			}
		}
	}

	/**
	 * Search all parameters
	 * @param  object $data   
	 * @param  object $config 
	 * @param  string $key    
	 * @param  string $value  
	 * @return object $key and $data
	 */
	private function getParams($data, $config, $key, $value = '')
	{
		if (! empty($value)) {
			if (! isset($data->$key->$value)) {
				if (! isset($config->$key->$value)) {
					throw new InvalidArgumentException("Não existe o parâmetro $value no arquivo de configuração moip.php");
				} else {
					return $config->$key->$value;
				}
			} else {
				return $data->$key->$value;
			}
		} else {
			if (! isset($data->$key)) {
				if (! isset($config->$key)) {
					throw new InvalidArgumentException("Não existe o parâmetro $value no arquivo de configuração moip.php");
				} else {
					return $config->$key;
				}
			} else {
				return $data->$key;
			}			
		}
	}

	/**
	 * Validation of billet
	 * @return void
	 */
	private function validatorBillet($data, $config)
	{
 		$data->billet = $this->getParams($data, $config, 'billet');
 		$data->billet->expiration = $this->getParams($data, $config, 'billet', 'expiration');
 		$data->billet->workingDays = $this->getParams($data, $config, 'billet', 'workingDays');
 		$data->billet->instructions = $this->getParams($data, $config, 'billet', 'instructions');
 		$data->billet->instructions->firstLine = $this->getParams($data->billet, $config->billet, 'instructions', 'firstLine');
 		$data->billet->instructions->secondLine = $this->getParams($data->billet, $config->billet, 'instructions', 'secondLine');
 		$data->billet->instructions->lastLine = $this->getParams($data->billet, $config->billet, 'instructions', 'lastLine');
 		$data->billet->urlLogo = $this->getParams($data, $config, 'billet', 'urlLogo');

		if (! is_bool($data->billet->workingDays)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($data->billet->workingDays) . ", esperava-se boleean");
		}

		foreach ($data->billet->instructions as $keyInstructions => $valueInstructions) {
			if (strlen($valueInstructions) > 63) {
				throw new UnexpectedValueException("Menssagens do boleto deve ser string e devem conter apenas 63 caractesres");		
			}
		}
	}

	/**
	 * Validation of comission
	 * @return void
	 */
	private function validatorComission($data, $config)
	{
		$data->comission 					= $this->getParams($data, $config, 'comission');
 		$data->comission->reason 			= $this->getParams($data, $config, 'comission', 'reason');
 		$data->comission->receiver 			= $this->getParams($data, $config, 'comission', 'receiver');
 		$data->comission->value 			= $this->getParams($data, $config, 'comission', 'value');
 		$data->comission->percentageValue 	= $this->getParams($data, $config, 'comission', 'percentageValue');
 		$data->comission->ratePayer 		= $this->getParams($data, $config, 'comission', 'ratePayer');

		if (! is_numeric($data->comission->value)) {
			throw new UnexpectedValueException("Parâmetro $data->comission->value dever ser numérico");
		}
		if (! is_bool($data->comission->percentageValue) || ! is_bool($data->comission->ratePayer)) {
			throw new UnexpectedValueException("PercentageValue e ratePayer devem ser do tipo boolean");
		}
	}

	/**
	 * Validation of params for parcel
	 * @return void
	 */
	private function validatorParcel($data, $config)
	{
		$data->parcel 			= $this->getParams($data, $config, 'parcel');
		$data->parcel->min 		= $this->getParams($data, $config, 'parcel', 'min');
		$data->parcel->max 		= $this->getParams($data, $config, 'parcel', 'max');
		$data->parcel->rate 	= $this->getParams($data, $config, 'parcel', 'rate');
		$data->parcel->transfer = $this->getParams($data, $config, 'parcel', 'transfer');

		if (! is_bool($data->parcel->transfer)) {
			throw new UnexpectedValueException("Espera-se boolean, foi passado ". gettype($data->parcel->transfer));
		}
	}

	/**
	 * Validator Basic
	 * @param  object $data   
	 * @param  object $config 
	 * @return void
	 */
	private function validatorBasic($data, $config)
	{
		if (! isset($data->values->value)) {
			throw new LogicException("Não foi informado o valor da compra", 1);
		} elseif (! is_numeric($data->values->value)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($data->values->value) . ", esperava-se float", 1);
		} elseif (! isset($data->reason)) {
			$data->reason = $this->getReason($config);
		}
	}

	/**
	 * Error who returned from API
	 * @param  string or boelan $error Error returned from API
	 * @return void
	 */
	protected function validatorResponseError($error)
	{
		if ($error !== false) {
			throw new Exception($error);
		}
	}

	/**
	 * validator Identification
	 * @param object $data 
	 * @param object $config 
	 * @return void
	 */
	private function validatorIdentification($data, $config)
	{
		$this->validatorBasic($data, $config);
	}

	/**
	 * Search result of buying in the configuration file MOIP
	 * @param  object $config configuration file Moip
	 * @return string         reason of purchase
	 */
	private function getReason($config)
	{
		if (! isset($config->reason)) {
			throw new InvalidArgumentException("Configuração reason em moip não foi encontrado", 1);
		} elseif (! ctype_alnum($config->reason)) {
				throw new UnexpectedValueException("Reason deve ser alfanumárico");
		} else {
			return $config->reason;
		}
	}

	/**
	 * Validation environment that is sent data
	 * @param  string $validate Environment
	 * @return string 			Environment
	 */
	protected function validatorValidate($validate)
	{
		if ($validate === 'Basic' || $validate === 'Identification') {
			return $validate;
		} else {
			throw new InvalidArgumentException("Configuração validade do moip aceita apenas 'Basic' e 'Identification'", 1);
		}
	}

	/**
	 * Authentication of token and key
	 * @param  object $credential token and key
	 * @return boolean
	 */
	protected function validatorCredential($credential)
	{
		if (! isset($credential->token) || ! isset($credential->key) ) {
			throw new InvalidArgumentException("Falha na Autenticação: ", 1);
		}
		return $this->validatorTokenKey($credential);
	}

	/**
	 * Validate token
	 * @return boolean       true
	 */
	private function validatorTokenKey($credential)
	{
		if (empty($credential) || strlen($credential->token) != 32 || strlen($credential->key) != 40) {
			throw new InvalidArgumentException("Credenciais incorretas");
		}
		return true;
	}
}