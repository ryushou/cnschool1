<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */


return array(

	/**
	 * Manual browscap parsing configuration.
	 *
	 * This will be used when your PHP installation has no browscap defined
	 * in your php.ini, httpd.conf or .htaccess, and you can't configure one.
	 */
	'browscap' => array(

		/**
		 * Location from where the updated browscap file can be downloaded.
		 *
		 * Note: these are temporary links awaiting relaunch of the browscap project
		 */
		'url' => 'http://browscap.org/stream?q=Lite_PHP_BrowsCapINI',  // only major browsers and search engines
		//'url' => 'http://tempdownloads.browserscap.com/stream.asp?Full_PHP_BrowscapINI',  // complete file, approx. 3 times the lite version
	),
);


