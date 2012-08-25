<?php
class Content_Admin_Menu extends Content_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
		$this->items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Add')),
				  'url' => $this->url().'add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Manage')),
				  'url' => $this->url().'list/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Permissions')),
				  'url' => $this->url().'permissions/'),			  
		);
	}
	public function execute($parent){
		$this->parent = $parent;
	}
	public function display($selected=false){
		$template = MCMS::Get_Instance()->output()->start(array('content','admin','menu'));
		$template->title = $this->title;
		$template->items = $this->items;
		$template->url = $this->url;
		$template->selected = $selected;
		return $template;
	}
}