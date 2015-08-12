<?php namespace SOSTheBlack\Moip\Commands;

use Illuminate\Console\Command;

class MoipConfigCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip:config';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Criar arquivo de configuracao';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->call('config:publish', ["--path" => "vendor/sostheblack/moip/src/config", "sostheblack/moip"]);
	}
}
