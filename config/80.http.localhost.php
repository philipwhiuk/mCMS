<?php
date_default_timezone_set('Europe/London');
return array(
	'storage' => array(
		'driver' => 'database'),
	'database' => array(
		'driver' => 'mysqli',
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'pilotman3',
		'database' => 'mcms',
		'socket' => ini_get("mysqli.default_socket"),
		'port' => ini_get("mysqli.default_port")
	),
	'site' => 1,
	'theme' => 3,
	'guest_user' => 1
);