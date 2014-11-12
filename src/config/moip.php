<?php 

/**
 * configuration required to integrate MoIP
 * @author Jean Cesar Garcia <jeancesargarcia@gmail.com>
 * @version v1.4.3
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 */
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

	'credentials' => [

		'key' 	=> 'ABABABABABABABABABABABABABABABABABABABAB',

		'token'	=> '01010101010101010101010101010101',
		
	],

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
	|
	| Min: Minimum number of parcel to the payer.
	| max: Maximum amount of parcel to the payer.
	| rate: Amount of interest a.m per plot.
	| Transfer: If "true" sets the default value of the interest will be paid 
	| by the payer MoIP
	*/

	'parcel' => [

		'active'	=> true,

		'min' 		=> 1,

		'max' 		=> 10,

		'rate'		=> 0,
		
		'transfer'	=> true,	

	],

	/*
	|--------------------------------------------------------------------------
	| Added Comission
	|--------------------------------------------------------------------------
	|
	| Used to define secondary recipients. You can also set one side to pay 
	| the fee MOIP recipients with the value received.
	|  
	| Reason 		 : Reason for which the secondary receiver is getting value.
	| receiver		 : Login MOIP secondary receiver.
	| value 		 : Value which will be allocated to the secondary receiver.
	| percentageValue: If "true" sets that value will be calculated in 
	| relation to the percentage of the total value of the transaction.
	| ratePayer		 : If "true" sets that secondary recipient will pay the MOIP 
	| withvalue received.
	|
	*/

	'comission' => [

		'active'			=> false,

		'reason' 			=> '',

		'receiver'			=> '',

		'value'				=> 0,

		'percentageValue' 	=> false,

		'ratePayer' 		=> false,

	],


	/*
	|--------------------------------------------------------------------------
	| Billet Config
	|--------------------------------------------------------------------------
	|
	| Responsible for setting additional configuration and customization of 
	| the banking Billet.
	|
	| expiration: Date in "YYYY-MM-DD" format or number of days.
	| workingDays: If "expiration" is the amount of days you can set to.
	| "true" to that is counted in business days, the default is calendar days.
	| instructions: Additional Message to be printed on the ticket, up to 
	| three messages.
	| urlLogo: URL of your logo maximum dimensions 75px wide by 40px high.
	|
	*/

	'billet' => [

		'expiration' => 10,

		'workingDays' => false,

		'instructions' => [

			'firstLine' => 'First line of comment of billet',

			'secondLine' => 'Second line of comment of billet',

			'lastLine' => 'Last line of comment of billet'

		],

		'urlLogo' => 'http://seusite.com.br/logo.png'
	],

	/*
	|--------------------------------------------------------------------------
	| Message to Checkout
	|--------------------------------------------------------------------------
	|
	| Display additional messages at checkout MOIP to your buyer.
	|
	*/

	'message' => [

		'firstLine' => '',

		'secondLine' => '',

		'lastLine' => ''
		
	],

	/*
	|--------------------------------------------------------------------------
	| Return URL
	|--------------------------------------------------------------------------
	|
	| responsible for defining the URL that the buyer will be redirected to 
	| finalize a payment through checkout MoIP
	|
	*/

	'returnURL' => 'https://meusite.com.br/pedidofinalizado',

	/* 
	|--------------------------------------------------------------------------
	| Notification URL
	|--------------------------------------------------------------------------
	|
	| responsible for defining the URL to which the MOIP shall notify to the 
	| NASP (Notification of Change in Status of Payment) the change of status.
	| Override the default URL registered in Portfolio MoIP for sending 
	| information on changes in the payment status.
	|
	*/

	'notificationURL' => '',

	/*
	|--------------------------------------------------------------------------
	| Payment Way
	|--------------------------------------------------------------------------
	|
	| Defines which forms of payment that will be displayed to the payer in 
	| Checkout MOIP
	|
	| billet: To provide a "Billet Banking" as payment option at checkout.
	| financing: To enable the "Financing" as payment option at checkout.
	| debit: To provide the "Debit account" as a payment method at checkout.
	| creditCard: To provide a "Credit Card" as payment option in checkout.
 	| debitCard: To provide a "Debit Card" as payment option in checkout.
	|
	*/

    'payment' => [

    	'creditCard'=> true,

    	'billet'	=> true,

    	'financing'	=> true,

    	'debit'		=> true,

    	'debitCard'	=> true

    ]	
];