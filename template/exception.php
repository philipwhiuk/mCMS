<?php

class Template_Exception extends CMS_Exception {}
class Template_Invalid_Exception extends Template_Exception {
	protected $level = System::dump_warning;
}
class Template_Not_Found_Exception extends Template_Exception {
	protected $level = System::dump_notice;
	public function message(){
		var_dump($this); exit;
	}
}
