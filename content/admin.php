<?php

class Content_Admin extends Admin {

	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('content'), array('view','edit','add','delete','list','admin'),'admin');
		$this->name = Language::Retrieve()->get($this->module, array('admin','menu','name'));
	}

	public function execute(){

	}

	public function display_menu(){
		$template = System::Get_Instance()->output()->start(array('content','admin','menu'));
		$template->url = $this->url;
		$template->name = $this->name;
		return $template;
	}

	public function display(){
		$template = System::Get_Instance()->output()->start(array('content','admin','panel'));
		return $template;
	}

}
