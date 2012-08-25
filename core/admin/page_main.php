<?php

class Admin_Page_Main extends Page_Main {

	private $panels;
	
	public static function Load_Main() {
	
	}
	public static function Load_Menu() {
	
	}
	
	public function __construct($parent){
		parent::__construct($parent);
		Permission::Check(array('admin'), array('panel'), 'panel');
		$this->panels = Admin::Create_All($this);
		$resource = $parent->resource();
		$arg = $resource->get_argument();
		if(isset($this->panels[$arg])){
			$this->panel =& $this->panels[$arg];
			$resource->consume_argument();
		} else {
			reset($this->panels);
			$this->panel = current($this->panels);
		}
	}

	public function resource(){
		return $this->parent->resource();
	}

	public function url($param = ''){
		return MCMS::Get_Instance()->url(
			Resource::Get_By_Argument(
				Module::Get('admin'),
				$param
			)->url()
		);
	}

	public static function Load($parent){
		try {
			return new Admin_Page_Main($parent);
		} catch (Exception $e){
			throw new Admin_Page_Main_Unavailable_Exception($e);
		}
	}

	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('admin','page'));
		$template->menu = array();
		foreach($this->panels as $i => $panel){
			$tMItem = array();
			$tMItem['selected'] = ($panel == $this->panel);
			
			$tMItem['value'] = $panel['menu']->display(($panel == $this->panel));
			$tMItem['module'] = $panel['menu']->module()->name();
			$tMItem['hasSubItems'] = $panel['menu']->menuHasSubItems();
			$template->menu[$i] = $tMItem;
		}
		$template->panel = $this->panel['main']->display();
		$template->title = "Admin";
		return $template;
	}
	
}
