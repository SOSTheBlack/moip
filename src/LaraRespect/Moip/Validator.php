<?php namespace LaraRespect\Moip;

use InvalidArgumentException;
use UnexpectedValueException;
use LengthException;
use LogicException;

class Validator
{
	protected function validatorData($data, $config)
	{
		if (! isset($data->unique_id)) {
			$data->unique_id = false;
		}

		if ($this->validatorValidate($config->validate) === 'Basic') {
			if (! isset($data->value)) {
				throw new LogicException("Não foi informado o valor da compra", 1);
			} elseif (! is_float($data->value)) {
				throw new UnexpectedValueException("Valor da compra deve ser do tipo float", 1);
			} elseif (! isset($data->reason)) {
				$data->reason = $this->getReason($config);
			}
		}
	}

	private function getReason($config)
	{
		if (! isset($config->reason)) {
			throw new InvalidArgumentException("Configuração reason em moip não foi encontrado", 1);	
		}
		return $config->reason;
	}

	protected function validatorConfig($config)
	{
		if (empty($config)) {
			throw new InvalidArgumentException("Arquivo de configuração moip não foi encontrado", 1);
		} else {
			return (object) $config;
		}
	}

	protected function validatorValidate($validate)
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
			throw new InvalidArgumentException("Falha na Autenticação: Não existe a chave token no arquivo do configuração do moip", 1);
		} elseif (! isset($credential->key)) {
			throw new InvalidArgumentException("Falha na Autenticação: Não existe a chave key no arquivo do configuração do moip", 1);
		}

		return $this->validatorToken($credential->token) && $this->validatorKey($credential->key);
	}

	private function validatorToken($token)
	{
		if (empty($token)) {
			throw new InvalidArgumentException("Falha na Autenticação: Token não pode estar vazio", 1);
		} elseif (strlen($token) != 32) {
			throw new LengthException("Falha na Autenticação: Tamanho do token não pode ser diferente de 32", 1);
		}
		return true;
	}

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