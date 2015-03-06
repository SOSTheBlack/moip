<?php

/**
 * Configuration required to integrate MoIP
 * 
 * @package Sostheblack\Moip
 * @author Jean C. Garcia <jeancesargarcia@gmail.com>
 * @version 2.0.0
 */
return [

	/**
	 * Defining application environment
	 * Configuration that defines the environment in which the request will 
	 * be processed
	 * The existing integration with MoIP environments are: development 
	 * (Sandbox) and production 
	 * If it is true, will be sent to the Development Environment 
	 * If it is false, is sent to the production environment
	 * 
	 * @package Sostheblack\Moip
	 * @subpackage Illuminate\Support
	 * @author Jean C. Garcia <jeancesargarcia@gmail.com>
	 * @author Colin Viebrock <colin@viebrock.ca>
	 * @version 2.0.0
	 * 
	 */
	'environment' => true,
];