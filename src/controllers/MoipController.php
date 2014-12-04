<?php namespace SOSTheBlack\Moip\Controllers;

use DB;
use View;

class MoipController
{
	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/

	private $data;

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	var $moip;

	/**
	 * transparent
	 * 
	 * @param array $data 
	 * @return void
	 */
	public function transparent(array $data)
	{
		$this->initialize($data);
		return View::make('sostheblack::moip')->withMoip($this->data);
	}

	/**
	 * initialize
	 * 
	 * @return void
	 */
	private function initialize($data)
	{
		$this->moip = DB::table('moip')->first();
		$this->data = $data;
		$this->data['environment'] = (boolean) $this->moip->environment;
	}
}