<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
	'default' => array(
	   'type'         => 'mysqli',
	   'connection'   => array(
	      'hostname'   => 'allpay.ccrylywvqzhy.ap-northeast-1.rds.amazonaws.com',
          'database'   => 'cnschool1',
          'username'   => 'allpayadmin',
          'password'   => 'xsw25tgb',
	      'persistent' => true,
	      'compress'   => true
	   ),
	   'table_prefix' => '',
	   'charset'      => 'utf8',
	   'enable_cache' => false,
	),
);
