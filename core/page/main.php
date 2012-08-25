<?php

abstract class Page_Main {
	
	protected $parent;
	
	protected function __construct($parent){
		$this->parent = $parent;
	}
	
	abstract public function display();
	
	//abstract public static function Load($parent);
	
}

