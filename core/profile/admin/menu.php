<?php
class Profile_Admin_Menu extends Profile_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
		$this->items = array();
	}
	public function display($selected=false){
		$template = MCMS::Get_Instance()->output()->start(array('profile','admin','menu'));
		$template->title = $this->title;
		$template->items = $this->items;
		$template->url = $this->url;
		$template->selected = $selected;
		return $template;
	}
}