<?php

class Admin_Dashboard extends Admin {

	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		$this->name = Language::Retrieve()->get($this->module, array('dashboard','menu','name'));
	}

	public function execute($parent){

	}

	public function display_menu(){
		$template = System::Get_Instance()->output()->start(array('admin','dashboard','menu'));
		$template->url = $this->url;
		$template->name = $this->name;
		return $template;
	}

	public function display(){
		$template = System::Get_Instance()->output()->start(array('admin','dashboard','panel'));
		return $template;
	}

}
