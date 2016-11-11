<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
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

	// the active pagination template
	'active'        => 'bootstrap3',
	'bootstrap3'    => array(
		'first-link'    => "<a href=\"{uri}\" value=\"{uri}\">{page}</a>",
		'previous-link' => "<a href=\"{uri}\" value=\"{uri}\" rel=\"prev\">{page}</a>",
		'active-link'   => "\t\t<a href=\"#\" value=\"{page}\">{page}</a>\n",
		'regular-link'  => "<a href=\"{uri}\" value=\"{page}\">{page}</a>",
		'next-link'     => "<a href=\"{uri}\" value=\"{uri}\" rel=\"next\">{page}</a>",
		'last-link'     => "<a href=\"{uri}\" value=\"{uri}\">{page}</a>",
	),
);
