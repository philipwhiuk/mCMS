<?php
class Team_Admin_Menu extends Team_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
	}
	public function display($selected=false){
		$template = MCMS::Get_Instance()->output()->start(array('team','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->title;
		return $template;
	}
}