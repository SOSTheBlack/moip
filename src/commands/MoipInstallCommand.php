<?php namespace SOSTheBlack\Moip\Commands;

use Illuminate\Console\Command;

class MoipInstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Complete installation and configuration';

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
		$this->call('moip:migrations');
		$this->call('moip:seeds');
		$this->call('moip:auth');
		$this->call('moip:reason');
		$this->call('moip:payment');
	}
}
