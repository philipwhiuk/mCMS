<?php
class Film_Feature_Admin_Menu extends Film_Feature_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->menu_feature_title = Language::Retrieve()->get($this->module, array('admin','menu','features','title'));
		$this->menu_feature_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','features','Add')),
				  'url' => $this->url().'features/add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','features','Manage')),
				  'url' => $this->url().'features/manage/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','features','Permissions')),
				  'url' => $this->url().'features/permissions/'),				  	  
		);	
		$this->menu_showing_title = Language::Retrieve()->get($this->module, array('admin','menu','showings','title'));
		$this->menu_showing_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','showings','Add')),
				  'url' => $this->url().'showings/add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','showings','Manage')),
				  'url' => $this->url().'showings/manage/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','showings','Permissions')),
				  'url' => $this->url().'showings/permissions/')				  
		);
	}
	public function display($selected=false){
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','menu'));
		$template->title = $this->menu_feature_title;
		$template->url = $this->url;
		$template->feature_title = $this->menu_feature_title;
		
		$template->feature_items = $this->menu_feature_items;
		$template->showing_title = $this->menu_showing_title;
		$template->showing_items = $this->menu_showing_items;
		$template->selected = $selected;
		return $template;
	}
}