<?php

class Film_Page_Main_List extends Film_Page_Main {
	
	private $film = array();
	
	public function __construct($parent){
		parent::__construct($parent);
		$film = Film::Get_All();
		foreach($film as $film){
			try {
			$film->get_description()->get_title();
			$this->film[] = $film;
			} catch (Content_Not_Found_Exception $e) {
			}
		}
		Permission::Check(array('film'), array('view','edit','add','delete','list'),'list');
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('film','page','list'));
		
		$language = Language::Retrieve();
		
		$system = MCMS::Get_Instance();
		
		$module = Module::Get('film');
		
		$template->title = $language->get($module, array('list','title'));
		
		foreach($this->film as $film){
			$template->film[] = array(
				'name' => $film->get_description()->get_title(),
				'url' => $system->url(Resource::Get_By_Argument($module, $film->get_id())->url())
			);
		}
		
		
		return $template;
	}
}