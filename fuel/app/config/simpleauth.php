<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
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
	 * DB connection, leave null to use default
	 */
	'db_connection' => null,

	/**
	 * DB table name for the user table
	 */
	'table_name' => 'users',

	/**
	 * Choose which columns are selected, must include: username, password, email, last_login,
	 * login_hash, group & profile_fields
	 */
	'table_columns' => array('id', 'username', 'group', 'email', 'password', 'login_hash', 'profile_fields'),

	/**
	 * This will allow you to use the group & acl driver for non-logged in users
	 */
	'guest_login' => true,

	/**
	 * This will allow the same user to be logged in multiple times.
	 *
	 * Note that this is less secure, as session hijacking countermeasures have to
	 * be disabled for this to work!
	 */
	'multiple_logins' => false,

	/**
	 * Remember-me functionality
	 */
	'remember_me' => array(
	    'enabled' => true,
	    'cookie_name' => 'rmcookie',
	    'expiration' => 86400*7
	),

	/**
	 * Groups as id => array(name => <string>, roles => <array>)
	 */
	'groups' => array(
		/**
		 * Examples
		 * ---
		 *
		 * -1   => array('name' => 'Banned', 'roles' => array('banned')),
		 * 0    => array('name' => 'Guests', 'roles' => array()),
		 * 1    => array('name' => 'Users', 'roles' => array('user')),
		 * 50   => array('name' => 'Moderators', 'roles' => array('user', 'moderator')),
		 * 100  => array('name' => 'Administrators', 'roles' => array('user', 'moderator', 'admin')),
		 */
		 -1   => array('name' => 'Banned', 'roles' => array('banned')),
		 0    => array('name' => 'Guests', 'roles' => array()),
		 1    => array('name' => 'Users', 'roles' => array('user', 'web')),

		 11   => array('name' => 'Accountant', 'roles' => array('user', 'admin', 'accountant')),
		 12   => array('name' => 'Orderer', 'roles' => array('user', 'admin', 'orderer')),
		 13   => array('name' => 'Shipper', 'roles' => array('user', 'admin', 'shipper')),
		 10   => array('name' => 'Administrator', 'roles' => array('user', 'admin', 'administrator', 'accountant', 'orderer', 'shipper')),

		 14   => array('name' => 'OEM_Orderer', 'roles' => array('user', 'admin', 'oem_orderer')),
		 15   => array('name' => 'OEM_Shipper', 'roles' => array('user', 'admin', 'oem_shipper')),
		 16   => array('name' => 'OEM_Administrator', 'roles' => array('user', 'admin', 'oem_administrator', 'oem_orderer', 'oem_shipper')),

		 100   => array('name' => 'Super', 'roles' => array('super')),
	),

	/**
	 * Roles as name => array(location => rights)
	 */
	'roles' => array(
		/**
		 * Examples
		 * ---
		 *
		 * Regular example with role "user" given create & read rights on "comments":
		 *   'user'  => array('comments' => array('create', 'read')),
		 * And similar additional rights for moderators:
		 *   'moderator'  => array('comments' => array('update', 'delete')),
		 *
		 * Wildcard # role (auto assigned to all groups):
		 *   '#'  => array('website' => array('read'))
		 *
		 * Global disallow by assigning false to a role:
		 *   'banned' => false,
		 *
		 * Global allow by assigning true to a role (use with care!):
		 *   'super' => true,
		 */

		'user'  => array(
			'event' => array('request'),
		),

		'web'  => array(
			'web' => array('menu'),
			'account' => array('remove'),
		),

		'admin'  => array(
			'admin' => array('menu'),
			'image' => array('user'),
			'bill' => array('report'),
			'invoice' => array('report'),
			'balance' => array('report'),
		),

		'accountant' => array(
			'user' => array('list'),
			'admin_user' => array('menu'),
			'deposit' => array('input', 'history'),
		),

		'orderer' => array(
			'order' => array('normal', 'list', 'send', 'new', 'edit', 'message'),
		),

		'shipper' => array(
			'order' => array('normal', 'list', 'message', 'amount'),
			'send' => array('input'),
			'bill' => array('finish'),
		),

		'administrator'  => array(
			'admin_user' => array('list'),
			'master' => array('update'),
		),

		'oem_orderer' => array(
			'order' => array('oem', 'list', 'send', 'new', 'edit', 'message'),
			'send' => array('input'),
		),

		'oem_shipper' => array(
			'order' => array('oem', 'list', 'message', 'amount'),
			'send' => array('input'),
			'bill' => array('finish'),
		),

		'oem_administrator'  => array(

		),

		# Global allow by assigning true to a role (use with care!):
		'super' => true,

		# Global disallow by assigning false to a role:
		'banned' => false,
	),

	/**
	 * Salt for the login hash
	 */
	'login_hash_salt' => 'koerpig7tfhu6',

	/**
	 * $_POST key for login username
	 */
	'username_post_key' => 'username',

	/**
	 * $_POST key for login password
	 */
	'password_post_key' => 'password',
);
