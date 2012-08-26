<?php
class Simm_Admin_Menu extends Simm_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
		$this->items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Characters')),
				  'url' => $this->url().'characters/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Departments')),
				  'url' => $this->url().'departments/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Fleets')),
				  'url' => $this->url().'fleets/'),			
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Missions')),
				  'url' => $this->url().'missions/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Positions')),
				  'url' => $this->url().'positions/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Ranks')),
				  'url' => $this->url().'ranks/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Simms')),
				  'url' => $this->url().'simms/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Specifications')),
				  'url' => $this->url().'specifications/'),		
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Technology')),
				  'url' => $this->url().'technology/'),	
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Uniforms')),
				  'url' => $this->url().'uniforms/'),					  
		);
	}
	public function display($selected=false){
		$template = MCMS::Get_Instance()->output()->start(array('simm','admin','menu'));
		$template->title = $this->title;
		$template->items = $this->items;
		$template->url = $this->url;
		$template->selected = $selected;
		return $template;
	}
}