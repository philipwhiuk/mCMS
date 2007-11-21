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
			return Install::Config($fusion);
		}
	}
	
	static function Storage($fusion, &$config){
		if(isset($config['site'])){
			$result = $fusion->storage->query("SELECT field, value FROM config WHERE site_id = %u", $config['site']);
			if($result){
				while($row = $result->fetch_row()){
					$config[$row[0]] = $row[1];
				}
			}
		} else {
			Install::Site($fusion, &$config);
		}
	}
	
}


