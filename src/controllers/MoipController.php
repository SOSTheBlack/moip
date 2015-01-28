<?php namespace SOSTheBlack\Moip\Controllers;

use Route;
use View;
use MoipApi;
use Moip;
use Input;
use BaseController;
use Request;
use Session;

class MoipController extends BaseController
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
	 * undocumented class variable
	 *
	 * @var string
	 **/
	protected $response;

	public function payment()
	{
		Session::put('moip', Input::all());
	}

	/**
	 * initialize
	 * 
	 * @return void
	 */
	private function initialize(array $data, $token)
	{
		$this->moip = Moip::firstOrFail();
		$this->data = array_replace_recursive($this->data, $data);
		if (empty($this->data['CartaoCredito']['Cofre'])) {
			unset($this->data['CartaoCredito']['Cofre']);
		}
		$this->data['token'] 		= $this->token($token);
		$this->data['environment'] 	= $this->environment();
	}

	private function token($token)
	{
		return $token ? $token : MoipApi::response()->token;
	}

	/**
	 * transparent
	 * 
	 * @param array $data 
	 * @param string $token
	 * @return Illuminate\View\Factory
	 */
	public function transparent(array $data, $token = null)
	{
		$this->initialize($data, $token);

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