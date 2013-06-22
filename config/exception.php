<?php

/**
 * Describes an exception thrown by the Config Module.
 */
class Config_Exception extends MCMS_Exception {}

/**
 * Indicates configuration settings could not be found
 */
class Config_Not_Found_Exception extends Config_Exception {

	protected $level = MCMS::dump_warning;

	public function dump(){ 
		$string = $this->message();
		foreach($this->data[0] as $e){
			$string .= "\r\n\t" . join("\r\n\t",explode("\r\n",$e->dump()));
		}
		return $string;
	}

	public function message(){
		return 'Configuration File Not Found.';
	}

}

/**
 * Indicates an error with a specified configuration key
 */
class Config_Key_Exception extends Config_Exception {}

/**
 * Indicates a specific configuration key could not be found
 */
class Config_Key_Not_Found_Exception extends Config_Key_Exception {}
