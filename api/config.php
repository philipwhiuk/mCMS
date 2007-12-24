<?php

/**
 * Config API File
 *
 * Subversion ID: $Id$
**/

class Config {

	static function File(){
		$confdir = './config';
		$config = array();
		$uri = explode('/', $_SERVER['SCRIPT_NAME'] ? $_SERVER['SCRIPT_NAME'] : $_SERVER['SCRIPT_FILENAME']);
		$server = explode('.', implode('.', array_reverse(explode(':', rtrim($_SERVER['HTTP_HOST'], '.')))));
		for ($i = count($uri) - 1; $i > 0; $i--) {
			for ($j = count($server); $j > 0; $j--) {
				$dir = implode('.', array_slice($server, -$j)) . implode('.', array_slice($uri, 0, $i));
				if(file_exists("{$confdir}/{$dir}.php")) {
					Log::Message("Config File {$confdir}/{$dir}.php used.");
					require_once("{$confdir}/{$dir}.php");
					return $config;
				}
			}
		}
		if(file_exists("{$confdir}/default.php")) {
			Log::Message("Config File {$confdir}/default.php used.");
			require_once("{$confdir}/default.php");
			return $config;
		} else {
			return Install::Config($fusion);
		}
	}
	
	static function Storage(){
		if(isset(Fusion::$_->config['site'])){
			$result = Fusion::$_->storage->query("SELECT field, value FROM config WHERE site_id = %u", Fusion::$_->config['site']);
			if($result){
				while($row = $result->fetch_row()){
					Fusion::$_->config[$row[0]] = $row[1];
				}
			}
			Log::Message("Dynamic configuration loaded.");
		} else {
			Install::Site(&$config);
		}
	}
	
}


