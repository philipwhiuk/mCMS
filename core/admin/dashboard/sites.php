<?php
class Admin_Dashboard_Sites extends Admin_Dashboard {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('dashboard','sites','edit'));
		$this->title = $language->get($this->module, array('dashboard','sites','title'));
		$this->siteName = $language->get($this->module, array('dashboard','sites','siteName'));
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','sites'));
		$template->title = $this->title;
		return $template;
	}
}