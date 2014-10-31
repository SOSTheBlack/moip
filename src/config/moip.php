<?php 

return [
	
	/*
	|--------------------------------------------------------------------------
	| Defining application environment
	|--------------------------------------------------------------------------
	|
	| Configuration that defines the environment in which the request will 
	| be processed
	| The existing integration with MoIP environments are: development 
	| (Sandbox) and production 
	| If it is true, will be sent to the Development Environment 
	| If it is false, is sent to the production environment
	|
	*/

	'environment' => true,

	/*
	|--------------------------------------------------------------------------
	| Credentials
	|--------------------------------------------------------------------------
	|
	| MoIP requires you to authenticate to be able to process requests in its 
	| API for it before making any request you must inform the MoIP credentials 
	| API formed by a TOKEN and a KEY.
	| Se você ainda não possui estes dados, veja como obtê-las através em sua 
	| conta Sandbox.
	|
	*/

	'key' 	=> 'ABABABABABABABABABABABABABABABABABABABAB',

	'token'	=> '01010101010101010101010101010101',

	/*
	|--------------------------------------------------------------------------
	| Validate Identification
	|--------------------------------------------------------------------------
	|
	| The validate() method will perform the validation required for the type 
	| of statement you want to process data, you can choose one of two levels 
	| of validation visible the 'Basic' and 'Identification'.
	|
	| Basic: Will perform validation on the minimum data for an XML request to 
	| MoIP. 
	| Identification: It will validate the data needed to process an XML 
	| identifying MoIP generally used to redirect the client in the second 
	| step of the payment page at checkout MoIP or use MoIP Transaparente.
	|
	*/

	'validate' => 'Basic',

	/*
	|--------------------------------------------------------------------------
	| Reaon
	|--------------------------------------------------------------------------
	|
	| Responsible for defining the reason for the payment.
	| 
	*/

	'reason' => 'Shopping',

	/*
	|--------------------------------------------------------------------------
	| User MoIP
	|--------------------------------------------------------------------------
	|
	| Identifies the MoIP user who will receive payment in MoIP
	|
	*/

	'receiver' => '',

	/*
	|--------------------------------------------------------------------------
	| Parcel
	|--------------------------------------------------------------------------
	|
	| Responsible for setting up the installment options that will be available
	| to the payer.
	| Min: Minimum number of parcel to the payer.
	| max: Maximum amount of parcel to the payer.
	| rate: Amount of interest a.m per plot.
	| Transfer: If "true" sets the default value of the interest will be paid 
	| by the payer MoIP
	*/

	'min' 		=> 1,

	'max' 		=> 12,

	'rate'		=> 2,
	
	'transfer'	=> false,	
];
