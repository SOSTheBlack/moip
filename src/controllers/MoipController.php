<?php namespace SOSTheBlack\Moip\Controllers;

use DB;
use View;
use Moip;

class MoipController
{
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
	 * undocumented class variable
	 *
	 * @var string
	 **/

	var $moip;

	/**
	 * initialize
	 * 
	 * @return void
	 */
	private function initialize(array $data)
	{
		$this->moip = DB::table('moip')->first();
		$this->data = array_replace_recursive($this->data, $data);
		if (empty($this->data['CartaoCredito']['Cofre'])) {
			unset($this->data['CartaoCredito']['Cofre']);
		}
		$this->data['token'] 		= Moip::response()->token;
		$this->data['environment'] 	= (boolean) $this->moip->environment;
	}

	/**
	 * transparent
	 * 
	 * @param array $data 
	 * @return void
	 */
	public function transparent(array $data)
	{
		$this->initialize($data);
		return View::make('sostheblack::moip')->withMoip($this->data);
	}

	
}