<?php 

Route::post('/sostheblack/moip', [
	'as'	=> 'sostheblack.moip',
	'uses'	=> 'SOSTheBlack\Moip\Controllers\MoipController@payment'
]);