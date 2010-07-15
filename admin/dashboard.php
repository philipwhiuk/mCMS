<?php

class Admin_Dashboard extends Admin {

	public function execute(){

	}

	public function display(){
		$template = System::Get_Instance()->output()->start(array('admin','dashboard'));
		return $template;
	}

}
