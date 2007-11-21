<?php

/**
 * Config API File
 *
 * Subversion ID: $Id$
**/

class Config {

	static function File($fusion){
		$confdir = './config';
		$config = array();
		$uri = explode('/', $_SERVER['SCRIPT_NAME'] ? $_SERVER['SCRIPT_NAME'] : $_SERVER['SCRIPT_FILENAME']);
		$server = explode('.', implode('.', array_reverse(explode(':', rtrim($_SERVER['HTTP_HOST'], '.')))));
		for ($i = count($uri) - 1; $i > 0; $i--) {
			for ($j = count($server); $j > 0; $j--) {
				$dir = implode('.', array_slice($server, -$j)) . implode('.', array_slice($uri, 0, $i));
				if(file_exists("{$confdir}/{$dir}.php")) {
					require_once("{$confdir}/{$dir}.php");
					return $config;
				}
			}
		}
		if(file_exists("{$confdir}/default.php")) {
			require_once("{$confdir}/default.php");
			return $config;
		} else {
			return Install::Config();
		}
	}
	
	static function Storage($fusion, &$config){
		
	
	}
	
}


