<?php

class Film_Page_Block_Main_View extends Film_Page_Block_Main {
	
	private $film;
	
	public function __construct($parent, $film){
		parent::__construct($parent);
		$this->film = $film;
		Permission::Check(array('film',$film->id()), array('view','edit','add','delete'),'view');
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('film','page','block','view'));
		$template->title = $this->film->get_title();
		$template->release_year = $this->film->get_release_year();
		return $template;
	}
	
}