<?php 

/**
 * Rota que irá processar os pagamentos
 */

Route::post(Config::get('sostheblack::moip.url'), [
	'as'	=> 'sostheblack.moip',
	'uses'	=> 'SOSTheBlack\Moip\Controllers\MoipController@response'
]);