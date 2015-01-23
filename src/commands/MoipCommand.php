<?php namespace SOSTheBlack\Moip\Commands;

use Moip;
use Illuminate\Console\Command;

class MoipCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'information on the commands';

	/**
	 * version od package
	 *
	 * @var string
	 **/
	private $version = '1.1.0';

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->logo();
		$this->information();
		$this->commands();
	}

	/**
	 * Commands of package
	 * 
	 * @return void
	 */
	private function commands()
	{
		$this->line(' <info>moip:install</info>			Instalacao e configuracao completa.');
		$this->line(' <info>moip:migrations</info>		Executa as migrations do package.');
		$this->line(' <info>moip:seeds</info>			Executa os seeds do package.');
		$this->line(' <info>moip:auth</info>			Configuracao referente a autenticacao e amboente.');
		$this->line(' <info>moip:receiver</info>			Definando recebedor primario.');
		$this->line(' <info>moip:reason</info>			Motivo da venda.');
		$this->line(' <info>moip:payment</info>			Configuracao referente aos metodos de pagamentos.');
		$this->line(' <info>moip:billet</info>			Configuracao do boleto bancario.');
		$this->line(' <info>moip:creditcard</info>		Configuracao do cartao de credito.');
		$this->line(' <info>moip:financing</info>			Configuracao do financiamento.');
		$this->line(' <info>moip:debit</info>			Configuracao do debito.');
		$this->line(' <info>moip:debitcard</info>			Configuracao do cartao de debito.');
	}

	/**
	 * information of package
	 * 
	 * @return void
	 */
	private function information()
	{
		$this->line('<info>Moip Package</info> version <comment>'.$this->version.'</comment>');
		$this->line('');
		$this->comment('Available commands:');
		$this->line('');
		$this->comment('moip');
	}

	/**
	 * logo
	 * 
	 * @return void
	 */
	private function logo()
	{
$this->line('
   _____ _____        __ 
  /  __  __   \___   /__/___
 /  / /  / /  / __ \___/    \
/  / /  / /  / /_/ /  / /_/ /
\_/  \_/  \_/\____/__/ .___/
                    /_/
');	
	}
}
