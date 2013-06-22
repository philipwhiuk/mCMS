<?php
/**
 * Menu for File administration.
 */
class File_Admin_Menu extends File_Admin {
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
	public function display($selected=false){
		$template = MCMS::Get_Instance()->output()->start(array('file','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->title;
		$template->items = $this->menu_items;
		return $template;
	}
}