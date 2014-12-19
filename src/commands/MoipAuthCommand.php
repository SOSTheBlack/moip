<?php namespace SOSTheBlack\Moip\Commands;

use Moip;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MoipAuthCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip:auth';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sets environment and credentials';

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
		$environment= $this->confirm('Sets environment [yes for production|no for Sandbox]') ? 'Moip' : 'Sandbox';
		$receiver 	= $this->ask('Enter the primary recipient of the '.$environment);
		$key 		= $this->ask('Enter the key of the '.$environment);
		$token 		= $this->secret('Enter the token of the '.$environment);
		$this->comment('Sending settings to the database');
		$moip = Moip::first();
		$moip->environment = $environment === 'Moip' ? 1 : 0;
		$moip->receiver = $receiver;
		$moip->key 		= $key;
		$moip->token 	= $token; 
		$moip->save();
		$this->line('<info>Seeded: </info>MoipCredentials');
		$this->comment('sent settings');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
