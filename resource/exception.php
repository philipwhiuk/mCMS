<?php

class Resource_Exception extends CMS_Exception {}
class Resource_Not_Found_Exception extends Resource_Exception {
	public function __construct($a, $b = null){
		$this->level = System::dump_warning;
		parent::__construct($a, $b);
	}
	public function message(){
		return get_class($this) . ' : ' . $this->data[0];
	}
}
