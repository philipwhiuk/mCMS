<?php

abstract class Menu_Impl {

	protected $menu;

	public function __construct($menu){
		$this->menu = $menu;
	}

}

class Menu_Menu_Impl extends Menu_Impl {
	
	protected $items;

	public function items(){

		if(!isset($this->items)){
			$this->items = Menu_Item::Get_By_Menu($this->menu);
		}

		return $this->items;

	}

}
