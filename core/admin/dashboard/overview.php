<?php
class Admin_Dashboard_Overview extends Admin_Dashboard {
	public function execute($parent) {
		parent::execute($parent);
		$this->mode = 'overview'; 
		$this->selected = 'Overview';		
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','overview'));
		return $template;
	}
}