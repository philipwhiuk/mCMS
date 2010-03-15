<?php

class Resource_Exception extends CMS_Exception {}
class Resource_Not_Found_Exception extends Resource_Exception {
	public function __construct(){
		$this->level = System::dump_warning;
		parent::__construct();
	}
}
