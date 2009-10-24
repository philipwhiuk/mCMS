<?php

class CMS_Exception extends Exception {

	protected $data;
	protected $message;
	
	public function  __construct(){
		parent::__construct(get_class($this) . isset($this->message) ? $this->message : '');
		$this->data = func_get_args();
		
	}

}

class System_Exception extends CMS_Exception {}
class System_Load_Exception extends System_Exception {}
class System_Not_Installed_Exception extends System_Exception {}
class System_Install_Exception extends System_Exception {}
class System_File_Not_Found_Exception extends System_Exception {}