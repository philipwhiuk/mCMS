<?php

class Menu_Exception extends CMS_Exception {}

class Menu_Not_Found_Exception extends Menu_Exception {}

class Menu_Page_Exception extends Menu_Exception {}

class Menu_Page_Unavailable_Exception extends Menu_Page_Exception {
	public function __construct(){
		$this->level = System::dump_warning;
		parent::__construct();
	}
}
