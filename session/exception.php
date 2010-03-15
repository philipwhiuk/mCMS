<?php

class Session_Exception extends CMS_Exception {}
class Session_Authentication_Exception extends Session_Exception {}
class Session_Authentication_Not_Found_Exception extends Session_Authentication_Exception {
	public function __construct(){
		$this->level = System::dump_notice;
		parent::__construct();
	}
}
