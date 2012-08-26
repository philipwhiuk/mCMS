<?php

class Admin_Page_Main extends Page_Main {

	private $panels;
	
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
			try {
				$panelMenu = call_user_func(array($panel['class'],'Load_Menu'),$panel['panel'], $panel['parent']);
				$tMItem = array();
				$tMItem['selected'] = ($panel == $this->panel);
				$tMItem['value'] = $panelMenu->display(($panel == $this->panel));
				$tMItem['module'] = $panelMenu->module()->name();
				$tMItem['hasSubItems'] = $panelMenu->menuHasSubItems();
				$template->menu[$i] = $tMItem;
			} catch (Exception $e) {
				//Silently ignore menu display errors
			}
		}
		$panelMain = call_user_func(array($this->panel['class'],'Load_Main'),$this->panel['panel'], $this->panel['parent']);
		if($panelMain != null) {
			$template->panel = $panelMain->display();
		} else {
			$template->panel = null;
		}
		$template->title = "Admin";
		return $template;
	}	
}