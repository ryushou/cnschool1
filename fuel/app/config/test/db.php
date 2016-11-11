<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */

return array(
	'default' => array(
		'type'         => 'mysqli',
		'connection'   => array(
	      'hostname'   => '153.120.59.70',
	      'database'   => 'gts_test',
	      'username'   => 'gts_test',
	      'password'   => 'dWvBSxJRUZVRhrce',
	      'persistent' => true,
	      'compress'   => true
	   ),
	   'table_prefix' => '',
	   'charset'      => 'utf8',
	   'enable_cache' => false,
	),
);
