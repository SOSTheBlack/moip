<?php namespace SOSTheBlack\Moip\Commands;

use Moip;
use stdClass;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MoipCommand extends Command {

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
	protected $description = 'Credentials and configuration of MoIP.';

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	private $data;

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
		if ($this->configureApi()) {
			$this->runningMigrations();
		}
		$this->info('End');
	}

	/**
	 * runningSeeds
	 * 
	 * @return void
	 */
	private function runningSeeds()
	{
		$this->comment('running seeds sostheblack/moip');
		$moip = new Moip;
		$moip->receiver		= $this->data->receiver;
		$moip->token		= $this->data->token;
		$moip->key			= $this->data->key;
		$moip->environment	= $this->data->environment == 'Moip' ? 1 : 0;
		$moip->save();

		$this->call('db:seed', ['--class' => 'DatabaseMoipSeeder']);
		
		$this->comment('finalized migration');	
	}

	/**
	 * configureApi
	 * 
	 * @return boolean
	 */
	private function configureApi()
	{
		$this->data = new stdClass();
		$this->data->environment = $this->confirm('Set the environment to be installed? [yes for production|no not for sandbox]')? 'Moip' : 'Sandbox';
		if ($this->confirm("Configure ".$this->data->environment."? [yes|no]")) {
			$this->data->receiver 	= $this->ask("Enter your account in ". $this->data->environment);
			$this->data->token 		= $this->ask("Enter your token in ".  $this->data->environment);
			$this->data->key 		= $this->secret("Enter your key in ".  $this->data->environment);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * migrations
	 * 
	 * Running migrations of package sostheblack/moip
	 * 
	 * @return void
	 */
	private function runningMigrations()
	{
		if ($this->confirm('Run migration package? [yes|no]')) {
			$this->comment('running migrations sostheblack/moip');
			$this->call('migrate', ['--bench'=> 'sostheblack/moip']);
			$this->comment('finalized migration');	
			if ($this->confirm('Run seeds package? [yes|no]')) {
				$this->runningSeeds();
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}
}
