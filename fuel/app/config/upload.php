<?php

return array(

	'path' => APPPATH.'tmp'.DS,

	/**
	 * file validation settings
	*/

	// maximum size of the uploaded file in bytes. 0 = no maximum
	'max_size'			=> 1024 * 500,

	// list of file extensions that a user is allowed to upload
	'ext_whitelist'		=> array('png', 'jpg', 'gif',),

	// list of file types that a user is allowed to upload
	// ( type is the part of the mime-type, before the slash )
	'type_whitelist'	=> array('image',),

	// list of file mime-types that a user is allowed to upload
	'mime_whitelist'	=> array('image/png', 'image/x-png', 'image/jpg', 'image/gif', 'image/jpeg',),
);