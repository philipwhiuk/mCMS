<?php

class Resource_Exception extends MCMS_Exception {}
class Resource_Not_Found_Exception extends Resource_Exception {
	public function __construct($a, $b = null){
		$this->level = MCMS::dump_notice;
		parent::__construct($a, $b);
	}
	public function message(){
		return get_class($this) . ' : ' . $this->data[0];
	}
}
