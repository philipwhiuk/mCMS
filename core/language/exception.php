<?php

class Language_Exception extends MCMS_Exception {}

class Language_Not_Found_Exception extends Language_Exception {}

class Language_Unavailable_Exception extends Language_Exception {}

class Language_File_Not_Found_Exception extends Language_Exception {
	public function __construct($error){
		$this->level = MCMS::dump_notice;
		parent::__construct($error);
	}

}

class Language_Translation_Not_Found_Exception extends Language_Exception {
	public function __construct($key, $error){
		if($error){
			$this->level = MCMS::dump_warning;
		} else {
			$this->level = MCMS::dump_notice;
		}
		parent::__construct($key, $error);
	}

	public function message(){
		return get_class($this) . ' ' . ($this->data[1] ? '!' : '?') . ' ' . join('/',$this->data[0]); 
	}
}
