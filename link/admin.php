<?php
class Link_Admin extends Admin {
	private $menu_title;
	private $menu_items = array();
	
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('link'), array('view','edit','add','delete','list','admin'),'admin');
		$this->menu_title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
		$this->menu_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Add')),
				  'url' => $this->url().'add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Manage')),
				  'url' => $this->url().'list/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Permissions')),
				  'url' => $this->url().'permissions/'),			  
		);		
	}	
	public function display() {}
	public function display_menu($selected) {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','menu'));
		$template->title = $this->menu_title;
		$template->items = $this->menu_items;
		$template->url = $this->url;
		$template->selected = $selected;
		return $template;
	}
	public function execute($parent){
		$this->parent = $parent;		
	}
	
}
