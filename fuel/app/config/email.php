<?php

return array(

	/**
	 * Default settings
	 */
	'defaults' => array(

		/**
		 * Mail useragent string
		 */
		'useragent'	=> 'fuelphp.',

		/**
		 * Mail driver (mail, smtp, sendmail, noop, ses)
		 */
		'driver'		=> 'ses',

		/**
		 * Whether to send as html, set to null for autodetection.
		 */
		'is_html'		=> null,

		/**
		 * Email charset
		 */
		'charset'		=> 'utf-8',

		/**
		 * Wether to encode subject and recipient names.
		 * Requires the mbstring extension: http://www.php.net/manual/en/ref.mbstring.php
		 */
		'encode_headers' => true,

		/**
		 * Newline
		 */
		'newline' => "\n",

		/**
		 * Ecoding (8bit, base64 or quoted-printable)
		 */
		'encoding'		=> '7bit',

		/**
		 * Email priority
		 */
		'priority'		=> \Email::P_NORMAL,

		/**
		 * Default sender details
		 */
		'from'		=> array(
			'email'		=> false,
			'name'		=> false,
		),

		/**
		 * Default return path
		 */
		'return_path'   => false,

		/**
		 * Whether to validate email addresses
		 */
		'validate'	=> true,

		/**
		 * Auto attach inline files
		 */
		'auto_attach' => true,

		/**
		 * Auto generate alt body from html body
		 */
		'generate_alt' => true,

		/**
		 * Forces content type multipart/related to be set as multipart/mixed.
		 */
		'force_mixed'   => false,

		/**
		 * Wordwrap size, set to null, 0 or false to disable wordwrapping
		 */
		'wordwrap'	=> 76,

		/**
		 * Path to sendmail
		 */
		'sendmail_path' => '/usr/sbin/sendmail',

		/**
		 * SMTP settings
		 */
		'smtp'	=> array(
			'host'		=> 'ssl://email-smtp.us-west-2.amazonaws.com',
			'port'		=> 465,
			'username'	=> 'AKIAJPI24MOLM52UONQQ',
			'password'	=> 'Agswm63YC/5CLMbugs+TRAQuIcBA5M/9Y07rC3ImQjjK',
			'timeout'	=> 10,
		),

		/**
		 * Attachment paths
		 */
		'attach_paths' => array(
			// absolute path
			'',
			// relative to docroot.
			DOCROOT,
		),
	),

	/**
	 * Default setup group
	 */
	'default_setup' => 'default',

	/**
	 * Setup groups
	 */
	'setups' => array(
		'default' => array(),
	),

);
