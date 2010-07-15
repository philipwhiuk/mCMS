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

		$this->panel->execute($this);
	}

	public function url($param = ''){
		return System::Get_Instance()->url(
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
		$template = System::Get_Instance()->output()->start(array('admin','page'));
		$template->menu = array();
		foreach($this->panels as $i => $panel){
			$template->menu[$i] = array('selected' => ($panel == $this->panel), 'value' => $panel->display_menu());
		}
		$template->panel = $this->panel->display();
		return $template;
	}
	
}
