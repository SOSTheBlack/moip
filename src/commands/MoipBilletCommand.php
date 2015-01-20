<?php namespace SOSTheBlack\Moip\Commands;

use Moip;
use Illuminate\Console\Command;

class MoipBilletCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moip:billet';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Banking billet settings.';

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
	 * @return mixed
	 */
	public function fire()
	{
		$moip = Moip::first();
		if ($this->confirm('Banking billet activated? [yes|no]')) {
			$expiration 	= $this->ask('Time after issuing the billet (in days):');
			$working_days	= $this->confirm('count only days useful? [yes|no]');
			$this->comment('Message in billet');
			$first_line		= $this->ask("First line:");
			$second_line	= $this->ask("Second line:");
			$last_line		= $this->ask("Last line:");
			$url_logo		= $this->ask("URL logo:");
			$moip->billet = true;
			$moip->expiration 	= $expiration;
			$moip->workingDays 	= $working_days;
			$moip->firstLine 	= $first_line;
			$moip->secondLine 	= $second_line;
			$moip->lastLine 	= $last_line;
			$moip->uriLogo 		= $url_logo;
		} else {
			$moip->billet = false;
		}
		$moip->save();
	}
}
