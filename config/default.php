<?php
date_default_timezone_set('Europe/London');
return array(
	'storage' => array(
		'driver' => 'database'),
	'database' => array(
		'driver' => 'mysqli',
		'host' => '',
		'username' => '',
		'password' => '',
		'database' => '',
		'socket' => ini_get("mysqli.default_socket"),
		'port' => ini_get("mysqli.default_port")
	),
	'site' => 1,
	'theme' => 1,
	'guest_user' => 1
);