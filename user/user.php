<?php

class User {
	
	public function get_id(){
		return $this->id;
	}
	
	public function authenticated(){
		return true;
	}
	
	protected function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	
	private $id;
	private $name;
	
}