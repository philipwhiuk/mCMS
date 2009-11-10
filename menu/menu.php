<?php

class Menu {

	private $id;
	private $name;
	
	private $resources;
	
	public function id(){
		return $this->id;
	}
	
	public function resources(){
		if(!isset($this->resources)){
			$this->resources = Menu_Resource::Get_By_Menu($this);
		}
		return $this->resources;
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