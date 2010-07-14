<?php

class Config_Exception extends CMS_Exception {}

class Config_Not_Found_Exception extends Config_Exception {

	protected $level = System::dump_warning;

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

class Config_Key_Exception extends Config_Exception {}

class Config_Key_Not_Found_Exception extends Config_Key_Exception {}
