<?php

/**
 * Storage API File
 *
 * Subversion ID: $Id$
**/

class Storage {

	static function Load(){	
		if(file_exists('./storage/' . Fusion::$_->config['storage'] . '.php')){
			require_once('./storage/' . Fusion::$_->config['storage'] . '.php');
			if(class_exists(Fusion::$_->config['storage'])){
				$c = Fusion::$_->config['storage'];
				Log::Message("Storage Engine {$c} loaded.");
				return new $c(Fusion::$_->config[$c]);
			}
		}
		return Install::Storage();
	}

}
