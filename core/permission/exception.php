<?php

class Permission_Exception extends MCMS_Exception {}
class Permission_Unauthorised_Exception extends Permission_Exception {
	public function __construct(){
		$this->level = MCMS::dump_warning;
		parent::__construct();
	}
}

class Permission_User_Exception extends Permission_Exception {}
class Permission_User_Not_Found_Exception extends Permission_User_Exception {
	public function __construct(){
		$this->level = MCMS::dump_notice;
		parent::__construct();
	}
}

class Permission_Group_Exception extends Permission_Exception {}
class Permission_Group_Not_Found_Exception extends Permission_Group_Exception {}
