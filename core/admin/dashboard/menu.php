<?php

class Admin_Dashboard_Menu extends Admin_Dashboard {
	protected $parent;
	protected $mode;
	
	public function __construct($a,$b){
		parent::__construct($a,$b);
		
		$this->url = $this->url();
		$this->title = Language::Retrieve()->get($this->module, array('dashboard','menu','title'));
		$this->items = array(
			array('title' => Language::Retrieve()->get($this->module, array('dashboard','menu','Overview')),
				  'url' => $this->url().'overview/','current' => false),
			array('title' => Language::Retrieve()->get($this->module, array('dashboard','menu','Resources')),
				  'url' => $this->url().'resources/','current' => false),				  
			array('title' => Language::Retrieve()->get($this->module, array('dashboard','menu','Modules')),
				  'url' => $this->url().'modules/','current' => false),
			array('title' => Language::Retrieve()->get($this->module, array('dashboard','menu','Updates')),
				  'url' => $this->url().'updates/','current' => false),
			array('title' => Language::Retrieve()->get($this->module, array('dashboard','menu','Settings')),
				  'url' => $this->url().'settings/','current' => false),	
			array('title' => Language::Retrieve()->get($this->module, array('dashboard','menu','Sites')),
				  'url' => $this->url().'sites/','current' => false),					  
			array('title' => Language::Retrieve()->get($this->module, array('dashboard','menu','Statistics')),
				  'url' => $this->url().'statistics/','current' => false),				  
		);		
	}
	public function display($selected = false){
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','menu'));
		$template->title = $this->title;
		$template->items = $this->items;
		$template->url = $this->url;
		$template->selected = $selected;
		return $template;
	}

}