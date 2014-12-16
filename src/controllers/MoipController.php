<?php namespace SOSTheBlack\Moip\Controllers;

use View;
use MoipApi;
use Moip;

class MoipController
{
	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/

	private $moip;

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/

	private $data = [
		"Forma" 		=> "",
		"Instituicao" 	=> "",
	    "Parcelas"		=> "",
	    "CartaoCredito" => [
	        "Numero" 		 => "",
	        "Expiracao" 	 => "",
	        "Cofre"			 => "",
	        "CodigoSeguranca"=> "",
	        "Portador" 		 => [
	        	"Nome" 			=> "",
	            "DataNascimento"=> "",
	            "Telefone" 		=> "",
	            "Identidade" 	=> ""
	        ]
	    ]
	];

	/**
	 * initialize
	 * 
	 * @return void
	 */
	private function initialize(array $data)
	{
		$this->moip = Moip::firstOrFail();
		$this->data = array_replace_recursive($this->data, $data);
		if (empty($this->data['CartaoCredito']['Cofre'])) {
			unset($this->data['CartaoCredito']['Cofre']);
		}
		$this->data['token'] 		= MoipApi::response()->token;
		$this->data['environment'] 	= $this->environment();
	}

	/**
	 * transparent
	 * 
	 * @param array $data 
	 * @return Illuminate\View\Factory
	 */
	public function transparent(array $data)
	{
		$this->initialize($data);
		return View::make('sostheblack::moip')->withMoip($this->data);
	}

	/**
	 * environment
	 * 
	 * @return string
	 */
	private function environment()
	{
		$environment = "";

		if ((boolean) $this->moip->environment === true) {
			$environment = "https://www.moip.com.br/transparente/MoipWidget-v2.js";
		} else {
			$environment = "https://desenvolvedor.moip.com.br/sandbox/transparente/MoipWidget-v2.js";
		}

		return $environment;
	}
}