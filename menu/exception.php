<?php

class Menu_Exception extends MCMS_Exception {}

class Menu_Not_Found_Exception extends Menu_Exception {}

class Menu_Page_Exception extends Menu_Exception {}

class Menu_Page_Unavailable_Exception extends Menu_Page_Exception {
	public function __construct(){
		$this->level = MCMS::dump_warning;
		parent::__construct();
	}
}
