<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'type'         => 'mysqli',
		'connection'   => array(
			'hostname' => '153.120.59.70',
	        // 'database' => 'gts_dev',
	        // 'username' => 'gts_dev',
	        // 'password' => 'vXDNNAXVNeY8P3d2',

	        'database'   => 'gts_test',
	        // 'database'   => 'gts_cos20160310',
	        'username'   => 'gts_test',
	        'password'   => 'dWvBSxJRUZVRhrce',

	        // 'database'   => 'gts_tmp',
	        // 'username'   => 'gts_tmp',
	        // 'password'   => 'cnfVyNMHj1wyLak',

	        'persistent' => true,
	        'compress'   => true
		),
		'profiling'    => true,
	),
);
