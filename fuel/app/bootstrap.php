<?php

// Load in the Autoloader
require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';


Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
	'Profiler' => APPPATH.'classes/profiler.php',
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
if(array_key_exists('HTTP_HOST', $_SERVER)) {
	if($_SERVER['HTTP_HOST'] == 'cos.kannihonkai.net'
		|| $_SERVER['HTTP_HOST'] == 'yiwumart.kannihonkai.net'
		|| $_SERVER['HTTP_HOST'] == 'yiwumart1.kannihonkai.net'
		|| $_SERVER['HTTP_HOST'] == 'cnschool.kannihonkai.net'
		|| $_SERVER['HTTP_HOST'] == 'cnschool1.kannihonkai.net') {
		Fuel::$env = Fuel::PRODUCTION;
	} else if($_SERVER['HTTP_HOST'] == 'gts.amalogs.com') {
		Fuel::$env = Fuel::TEST;
	} else {
		Fuel::$env = Fuel::DEVELOPMENT; // cos.amalogs.com
	}
} else {
	Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::PRODUCTION);
}

// Initialize the framework with the config file.
Fuel::init('config.php');
