<?php namespace LaraRespect\Moip;

use RuntimeException;

/**
 * Exception 
 * RuntimeException 
 * InvalidUserException 
 */
class Validator
{
	protected function config($config)
	{
		if (empty($config)) {
			throw new RuntimeException ("Arquivo de configuração não foi encontrado (moip.php)", E_ERROR);
		} else {
			return $config;
		}
	}
}