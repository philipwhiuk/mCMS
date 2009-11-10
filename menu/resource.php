<?php

class Menu_Resource {
	
	private $id;
	private $menu;
	private $name;
	private $resource;
	private $additional;
	private $parent;
	private $sort;
	
	public function id(){
		return $this->id;
	}
	
	public function name(){
		return $this->name;
	}
	
	public function parent(){
		return $this->parent;
	}
	
	public function resource(){
		if(!($this->resource instanceof Resource)){
			$this->resource = Resource::Get_By_ID($this->resource);
			$this->resource->set_additional($this->additional);
		}
		return $this->resource;
	}
	
	public static function Get_By_Menu($menu){
		
		if($menu instanceof Menu){
			$menu = $menu->id();
		}
		
		$query = System::Get_Instance()->database()->Select()->table('menu_resources')->where('=', array(
			array('col', 'menu'),
			array('u', $menu)
		))->order(array('sort' => true));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Menu_Resource')){
			$return[] = $row;
		}
		
		return $return;
		
	}
	
}