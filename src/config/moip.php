<?php 

return [

	/*
	|----------------------------------------------------------------------------------------------
	| Environment
	|----------------------------------------------------------------------------------------------
	|
	| Configuration that defines the environment in which the request will be processed. 
	| true to define what is in the test environment, MoIP Sandbox
	| false to define that the request should be processed in real environment, production MoIP.
	|
	| Important: to set the environment make sure you are using the corresponding 
	| authentication when environment in MoIP each environment has its own API keys authentication.
	|
	*/

	'environment' => true,

	/*
	|----------------------------------------------------------------------------------------------
	| Credentials
	|----------------------------------------------------------------------------------------------
	|
	| MoIP requires you to authenticate to be able to process requests in their API for it before 
	| making any request you must inform the MoIP credentials API formed by a TOKEN and a KEY.
	|
	*/

	'key' => '4IJLTMUNZL4DZRDGW1GB5E36GMQCAAFXYEUOBARD',
	'token' => 'FPOQZTQL36BQSLLZKMLQS8J7RKLHLBR3',

	/*
	|----------------------------------------------------------------------------------------------
	| Validate
	|----------------------------------------------------------------------------------------------
	|
	| The validate configuration will perform validation of data required for the type of 
	| instruction that you want to process, you can choose one of two levels of validation 
	| available the 'Basic' and 'Identification'.
	| Basic: Will perform validation on the minimum data for an XML request to MoIP.
	| Identification: It will validate the data needed to process an XML with identification MoIP 
	| generally used to redirect the client in the second step of the payment page
	| at checkout MoIP or use MoIP Transaparente.
	|
	*/

	'validate' => 'Basic',

	
];