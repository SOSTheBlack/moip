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
//    _____ _____        __ 
//   /  __  __   \___   /__/___
//  /  / /  / /  / __ \___/    \
// /  / /  / /  / /_/ /  / /_/ /
// \_/  \_/  \_/\____/__/ .___/ 
//                     /_/
$this->info('   _____ _____        __ 
  /  __  __   \___   /__/___
 /  / /  / /  / __ \___/    \ ');
$this->line('/  / /  / /  / /_/ /  / /_/ /');
$this->comment('\_/  \_/  \_/\____/__/ .___/
                    /_/
');
		$this->line('<info>Moip Package</info> version <comment>1.0.1</comment>');
		$this->line('');
		$this->comment('Available commands:');
		$this->line('');
		$this->comment('moip');
		$this->line(' <info>moip:auth</info>			Sets environment and credentials');
		$this->line(' <info>moip:install</info>			Complete installation and configuration');
		$this->line(' <info>moip:migrations</info>		Running migrations of package');
		$this->line(' <info>moip:seeds</info>			Running seeds of package');
	}
}
