<?php
class Gallery_Admin_Menu extends Gallery_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->title = Language::Retrieve()->get($this->module, array('admin','menu','gallery','title'));
		$this->items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','gallery','Add')),
				  'url' => $this->url().'add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','gallery','ManageG')),
				  'url' => $this->url().'list/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','gallery','ManageI')),
				  'url' => $this->url().'items/manage/'),					  
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','gallery','Permissions')),
				  'url' => $this->url().'permissions/'));
	}
	public function display($selected=false){
		$template = MCMS::Get_Instance()->output()->start(array('gallery','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->title;
		$template->items = $this->items;	
		$template->selected = $selected;
		return $template;
	}
}