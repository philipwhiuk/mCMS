<?php

class Menu_Item {

	private $id;
	private $menu;
	private $child;
	private $resource;
	private $additional;
	private $sort;
	private $name;

	public function id(){
		return $this->id;
	}

	public function name(){
		return $this->name;
	}

	public function child(){
		if($this->child instanceof Menu){
			return $this->child;
		} elseif((int) $this->child === 0){
			return 0;
		} else {
			$this->child = Menu::Get_By_ID($this->child);
			return $this->child;
		}
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
		
		$query = MCMS::Get_Instance()->database()->Select()->table('menu_item')->where('=', array(
			array('col', 'menu'),
			array('u', $menu)
		))->order(array('sort' => true));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Menu_Item')){
			$return[] = $row;
		}
		
		return $return;

	}
}
