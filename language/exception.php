<?php

class Language_Exception extends CMS_Exception {}

class Language_Not_Found_Exception extends Language_Exception {}

class Language_Unavailable_Exception extends Language_Exception {}

class Language_File_Not_Found_Exception extends Language_Exception {
	public function __construct($error){
		$this->level = System::dump_notice;
		parent::__construct($error);
	}

}

class Language_Translation_Not_Found_Exception extends Language_Exception {
	public function __construct($key, $error){
		if(!$error){
			$this->level = System::dump_notice;
		}
		parent::__construct($key);
	}
}
