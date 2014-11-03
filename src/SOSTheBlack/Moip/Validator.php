<?php namespace SOSTheBlack\Moip;

use UnexpectedValueException;
use InvalidArgumentException;
use LengthException;
use LogicException;
use Exception;
use StdClass;

/**
 * Class to validate all data Moip
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
		$data = $this->toObject($data);
		$data->values 	 = $this->toObject($data, 'values', true);
		$data->parcel 	 = $this->toObject($data, 'parcel');
		$data->comission = $this->toObject($data, 'comission');
		$data->billet	 = $this->toObject($data, 'billet');
		$data->billet->instructions = $this->toObject($data->billet, 'instructions') ;
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
			$config 				= $this->toObject($config);
			$config->credentials 	= $this->toObject($config, 'credentials', true);
			$config->parcel 		= $this->toObject($config, 'parcel', true);
			$config->comission 		= $this->toObject($config, 'comission', true);
			$config->billet 		= $this->toObject($config, 'billet');
			$config->billet->instructions = $this->toObject($config->billet, 'instructions');
			return $config;
		}
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
				return (object) $data->$value = new stdClass();
			} else {
				return (object) $data->$value;
			}
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
		} else {
			$this->validatorBasic($data, $config);
		}

		if (isset($data->unique_id)) {
			if (! ctype_alnum($data->unique_id) && ! is_bool($data->unique_id) ) {
				throw new UnexpectedValueException("reason deve ser alfanumárico");
			}
		} else {
			$data->unique_id = false;
		}

		if (! isset($data->values->adds)) {
			$data->values->adds = 0.0;
		} elseif (! is_float($data->values->adds) || ! is_double($data->values->adds)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($data->values->deduct) . ", esperava-se float");
		}

		if (! isset($data->values->deduct)) {
			$data->values->deduct = 0.0;
		} elseif (! is_float($data->values->deduct) || ! is_double($data->values->deduct) ) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($data->values->deduct) . ", esperava-se float");
		}

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
		
		$data->parcel 			= $this->getParams($data, $config, 'parcel');
		$data->parcel->min 		= $this->getParams($data, $config, 'parcel', 'min');
		$data->parcel->max 		= $this->getParams($data, $config, 'parcel', 'max');
		$data->parcel->rate 	= $this->getParams($data, $config, 'parcel', 'rate');
		$data->parcel->transfer = $this->getParams($data, $config, 'parcel', 'transfer');
		$this->validatorParcel($data->parcel);

		$data->comission 					= $this->getParams($data, $config, 'comission');
 		$data->comission->reason 			= $this->getParams($data, $config, 'comission', 'reason');
 		$data->comission->receiver 			= $this->getParams($data, $config, 'comission', 'receiver');
 		$data->comission->value 			= $this->getParams($data, $config, 'comission', 'value');
 		$data->comission->percentageValue 	= $this->getParams($data, $config, 'comission', 'percentageValue');
 		$data->comission->ratePayer 		= $this->getParams($data, $config, 'comission', 'ratePayer');
 		$this->validatorComission($data->comission);

 		$data->billet = $this->getParams($data, $config, 'billet');
 		$data->billet->expiration = $this->getParams($data, $config, 'billet', 'expiration');
 		$data->billet->workingDays = $this->getParams($data, $config, 'billet', 'workingDays');
 		$data->billet->instructions = $this->getParams($data, $config, 'billet', 'instructions');
 		$data->billet->instructions->firstLine = $this->getParams($data->billet, $config->billet, 'instructions', 'firstLine');
 		$data->billet->instructions->secondLine = $this->getParams($data->billet, $config->billet, 'instructions', 'secondLine');
 		$data->billet->instructions->lastLine = $this->getParams($data->billet, $config->billet, 'instructions', 'lastLine');
 		$data->billet->urlLogo = $this->getParams($data, $config, 'billet', 'urlLogo');
 		$this->validatorBillet($data->billet);
	}

	/**
	 * Validation of billet
	 * @param  object $billet billet info
	 * @return void
	 */
	private function validatorBillet($billet)
	{
		if (! is_integer($billet->expiration) && ! is_string($billet->expiration)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($billet->expiration) . ", esperava-se integer ou string de data");
		}
		if (! is_bool($billet->workingDays)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($billet->workingDays) . ", esperava-se boleean");
		}
		if (! is_object($billet->instructions)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($billet->instructions) . ", esperava-se object");
		}
		if (! is_string($billet->instructions->firstLine) || ! is_string($billet->instructions->secondLine) || ! is_string($billet->instructions->lastLine)) {
			throw new UnexpectedValueException("Menssagens do boleto devem ser alfanuméricos");	
		}
		if (strlen($billet->instructions->firstLine) > 63 || strlen($billet->instructions->secondLine) > 63 || strlen($billet->instructions->lastLine) > 63) {
			throw new InvalidArgumentException("Menssagens do boleto não devem conter mais de 63 caracteres");	
		}
		if (! is_string($billet->urlLogo)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($billet->utlLogo) . ", esperava-se string");
		}
		if (strlen($billet->urlLogo) > 256) {
			throw new InvalidArgumentException("Menssagens do boleto não devem conter mais de 256 caracteres");	
		}
	}

	/**
	 * Validation of comission
	 * @param  object $comission comission info
	 * @return void
	 */
	private function validatorComission($comission)
	{
		if (! is_numeric($comission->value)) {
			throw new UnexpectedValueException("Parâmetro $comission->value dever ser numérico");
		}
		if (! is_bool($comission->percentageValue)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($comission->percentageValue) . ", esperava-se boolean");
		}
		if (! is_bool($comission->ratePayer)) {
			throw new UnexpectedValueException("Parametro passado é do tipo ". gettype($comission->ratePayer) . ", esperava-se boolean");
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
	 * Validation of params for parcel
	 * @param  object $parcel 
	 * @return void
	 */
	private function validatorParcel($parcel)
	{
		if (! is_int($parcel->min)) {
			throw new UnexpectedValueException("Espera-se inteiro, foi passado ". gettype($parcel->min));
		} elseif ($parcel->min < 2 && $parcel->min > 12) {
			throw new InvalidArgumentException("Parcela minima tem que estar entre 2 e 12");
		} elseif (! is_int($parcel->max)) {
			throw new UnexpectedValueException("Espera-se inteiro, foi passado ". gettype($parcel->max));
		} elseif ($parcel->max < 2 && $parcel->max > 12) {
			throw new InvalidArgumentException("Parcela maxima tem que estar entre 2 e 12");
		}

		if (! is_numeric($parcel->rate)) {
			throw new UnexpectedValueException("Espera-se float, foi passado ". gettype($parcel->rate));
		} elseif (strlen($parcel->rate) > 7) {
			throw new InvalidArgumentException("Não pode conter mais de 7 caracteres");
		}

		if (! is_bool($parcel->transfer)) {
			throw new UnexpectedValueException("Espera-se boolean, foi passado ". gettype($parcel->transfer));
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
		} elseif (! is_float($data->values->value)) {
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
		if (! isset($credential->token)) {
			throw new InvalidArgumentException("Falha na Autenticação: Não existe a chave token no arquivo do configuração do moip", 1);
		} elseif (! isset($credential->key)) {
			throw new InvalidArgumentException("Falha na Autenticação: Não existe a chave key no arquivo do configuração do moip", 1);
		}

		return $this->validatorToken($credential->token) && $this->validatorKey($credential->key);
	}

	/**
	 * Validate token
	 * @param  string $token
	 * @return boolean       true
	 */
	private function validatorToken($token)
	{
		if (empty($token)) {
			throw new InvalidArgumentException("Falha na Autenticação: Token não pode estar vazio", 1);
		} elseif (strlen($token) != 32) {
			throw new LengthException("Falha na Autenticação: Tamanho do token não pode ser diferente de 32", 1);
		}
		return true;
	}

	/**
	 * Validate key
	 * @param  string $key
	 * @return boolean     true
	 */
	private function validatorKey($key)
	{
		if (empty($key)) {
			throw new InvalidArgumentException("Falha na Autenticação: Key não pode estar vazio", 1);
		} elseif (strlen($key) != 40) {
			throw new LengthException("Falha na Autenticação: Tamanho de key não pode ser diferente 40", 1);
		} else {
			return true;
		}
	}
}