<?php

class Module_Exception extends CMS_Exception {}

class Module_Invalid_Exception extends Module_Exception {}
class Module_Not_Found_Exception extends Module_Exception {}
class Module_Circular_Dependancy_Exception extends Module_Exception {

        public function message(){
		return 'Module ' . $this->data[0] . ' is already being loaded - circular dependancy.';
	}
}
class Module_Load_Exception extends Module_Exception {}
class Module_Not_Available_Exception extends Module_Exception {}
class Module_File_Not_Found_Exception extends Module_Exception {
	public function __construct($message){
		$this->level = System::dump_notice;
		parent::__construct($message);
	}
}

class Module_Section_Exception extends Module_Exception {}
class Module_Section_Invalid_Exception extends Module_Section_Exception {}
