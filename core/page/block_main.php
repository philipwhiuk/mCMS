<?php

abstract class Page_Block_Main {
	
	protected $parent;
	
	abstract public function display();
	
	public function __construct($parent){
		$this->parent = $parent;
	}
	
	//abstract public static function Load($parent);
	
}