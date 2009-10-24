<?php

abstract class Page_Main {
	
	protected $parent;
	
	public function __construct($parent){
		$this->parent = $parent;
	}
	
	abstract public function display();
	
	abstract public static function Load($parent);
	
}