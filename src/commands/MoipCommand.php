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
		$this->line(' <info>moip:install</info>			Complete installation and configuration.');
		$this->line(' <info>moip:migrations</info>		Running migrations of package.');
		$this->line(' <info>moip:seeds</info>			Running seeds of package.');
		$this->line(' <info>moip:auth</info>			Sets environment and credentials.');
		$this->line(' <info>moip:receiver</info>			Setting the primary receiver.');
		$this->line(' <info>moip:reason</info>			New reason sales.');
		$this->line(' <info>moip:payment</info>			Settings related to payment methods.');
		$this->line(' <info>moip:billet</info>			Banking billet settings.');
		$this->line(' <info>moip:creditcard</info>		Cred Card settings.');
		$this->line(' <info>moip:financing</info>			Financing settings.');
		$this->line(' <info>moip:debit</info>			Debit settings.');
		$this->line(' <info>moip:debitcard</info>			Debit Card settings.');
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
$this->info('   _____ _____        __ 
  /  __  __   \___   /__/___
 /  / /  / /  / __ \___/    \ ');
$this->line('/  / /  / /  / /_/ /  / /_/ /');
$this->comment('\_/  \_/  \_/\____/__/ .___/
                    /_/
');	
	}
}
