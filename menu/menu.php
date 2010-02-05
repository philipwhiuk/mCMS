<?php

class Menu {

	private $id;
	private $name;
	private $req_factor;
	private $implementation;
	private $resources;
	
	public function id(){
		return $this->id;
	}

	public function module(){
		if(!($this->module instanceof Module)){
			$this->module = Module::Get_ID($this->module);
		}
		return $this->module;
	}

	public function impl(){
		if(!isset($this->implementation)){
			$class = $this->module()->load_section("Menu_Impl");
			$this->implementation = new $class($this);
		}
		return $this->implementation;
	}
	
	public function req_factor(){
		return $this->req_factor;
	}
	
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('menus')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Menu_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Menu');
		
	}
	
}
