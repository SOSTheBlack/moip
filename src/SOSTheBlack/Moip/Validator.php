<?php namespace SOSTheBlack\Moip;

use UnexpectedValueException;
use InvalidArgumentException;
use LengthException;
use LogicException;
use Exception;

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
		$data->values = $this->toObject($data, 'values', true);
		return $data;
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
				throw new LogicException("É necessário enviar os valores da compra", 1);
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
	 * Verifies the existence of the configuration file Moip
	 * @param  array $config Moip the configuration
	 * @return object        Moip the configuration
	 */
	protected function validatorConfig($config)
	{
		if (empty($config)) {
			throw new InvalidArgumentException("Arquivo de configuração moip não foi encontrado", 1);
		} else {
			return (object) $config;
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
