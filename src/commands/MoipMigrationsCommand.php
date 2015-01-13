<?php namespace SOSTheBlack\Moip\Commands;

use Illuminate\Console\Command;

class MoipMigrationsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip:migrations';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Running migrations of package';

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
		if ($this->confirm('Run migration package? [yes|no]')) {
			$this->comment('running migrations sostheblack/moip');
			$this->call('migrate', ['--bench'=> 'sostheblack/moip']);
			$this->comment('finalized migration');	
		}
	}
}
