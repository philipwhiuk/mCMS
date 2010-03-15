<?php

abstract class Feed_Main {

	protected $parent;

	protected function __construct($parent){
		$this->parent = $parent;
	}

	abstract function display();

	abstract public static function Load($parent);

}

