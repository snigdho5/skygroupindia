<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
*  Group name for active connection.
*  If empty, will be activated group #default.
*/


$config['mongo_db']['active_config_group'] = 'default';


/**
*  Connection settings for #default group.
*/


$config['mongo_db']['default'] = [
	'settings' => [
		'auth'             => FALSE,
		'debug'            => TRUE,
		'return_as'        => 'array',
		//'return_as'        => 'object',
		'auto_reset_query' => TRUE
	],

	'connection_string' => '',

	'connection' => [
		'host'          => '192.168.11.8',
		'port'          => '27017',
		'user_name'     => '',
		'user_password' => '',
		'db_name'       => 'skygoupindia_16062021',
		'db_options'    => []
	],

	'driver' => []
];

/* End of file mongo_db.php */
/* Location: ./application/config/mongo_db.php */