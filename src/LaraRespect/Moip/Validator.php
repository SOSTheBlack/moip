<?php namespace LaraRespect\Moip;

use InvalidArgumentException;

class Validator
{
	protected function validatorConfig($config)
	{
		if (empty($config)) {
			throw new InvalidArgumentException("Arquivo de configuração moip não foi encontrado", 1);
		} else {
			return $config;
		}
	}

	protected function validatorValidade($validate)
	{
		if ($validate === 'Basic' || $validate === 'Identification') {
			return $validate;
		} else {
			throw new InvalidArgumentException("Configuração validade do moip aceita apenas 'Basic' e 'Identification'", 1);	
		}
	}

	protected function validatorCredential($credential)
	{
		if (! isset($credential->token)) {
			throw new Exception("Error Processing Request", 1);
		} else {
			$this->validatorToken($credential->token);
		}
	}

	private function validatorToken($token)
	{
		
	}
}