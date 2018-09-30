<?php

return [

	/*
	|--------------------------------------------------------------------------
	| API Credentials
	|--------------------------------------------------------------------------
	|
	| Api credentials for paypal
	*/

    'api_credential' => [
		'paypal_email'     => env('PAYPAL_EMAIL', ''),
		'paypal_client_id' => env('PAYPAL_CLIENT_ID', ''),
		'paypal_secret'    => env('PAYPAL_SECRET', ''),
    ],


    /*
	|--------------------------------------------------------------------------
	| Base config
	|--------------------------------------------------------------------------
	|
	| Base config for payment
	*/

	'config' => [
		'mode'             => env('PAYPAL_CFG_MODE', 'live'),
		'service.EndPoint' => env('PAYPAL_CFG_ENDPOINT', 'https://api.paypal.com'),
		'log.LogEnabled'   => env('PAYPAL_CFG_LOG', true),
		'log.FileName'     => storage_path("logs/paypal-".date("Y-m-d").".log"),
		'log.LogLevel'     => env('PAYPAL_CFG_LOG_LEVEL', 'FINE'),
		'cache.enabled'    => env('PAYPAL_CFG_CACHE', true)
	],

];
