<?php namespace SOSTheBlack\Moip\Commands;

use Illuminate\Console\Command;

class MoipAssetsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip:assets';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publicar assests view em sua aplicacao.';

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
		$this->call('asset:publish', ['sostheblack/moip']);
	}
}
