<?php

/**
 * Storage API File
 *
 * Subversion ID: $Id$
**/

class Storage {

	static function Start($fusion, $config){	
		if(file_exists('./storage/' . $config['storage'] . '.php')){
			require_once('./storage/' . $config['storage'] . '.php');
			if(class_exists($config['storage'])){
				$c = $config['storage'];
				return new $c($config[$c], $fusion);
			}
		}
	}

}