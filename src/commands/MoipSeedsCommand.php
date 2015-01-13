<?php namespace SOSTheBlack\Moip\Commands;

use Moip;
use Illuminate\Console\Command;

class MoipSeedsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip:seeds';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Running seeds of package';

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
		if ($this->confirm('Run seeds package? [yes|no]')) {
			$this->comment('running seeds sostheblack/moip');
			if (Moip::all()->count() === 0) {
				Moip::create([]);
				$this->line('<info>Seeded: </info>MoipSeeder');
			}
			$this->call('db:seed', ['--class' => 'DatabaseMoipSeeder']);
			$this->comment('finalized migration');
		}
	}
}
