<?php namespace LaraRespect\Moip;

use InvalidArgumentException;
use LengthException;

class Validator extends Api
{
	protected function validatorConfig($config)
	{
		if (empty($config)) {
			throw new InvalidArgumentException("Arquivo de configuração moip não foi encontrado", 1);
		} else {
			return (object) $config;
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