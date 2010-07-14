<?php

class Film_Page_Main_List extends Film_Page_Main {
	
	private $film;
	
	public function __construct($parent){
		parent::__construct($parent);
		$this->film = Film::Get_All();
		Permission::Check(array('film'), array('view','edit','add','delete','list'),'list');
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('film','page','list'));
		
		$language = Language::Retrieve();
		
		$system = System::Get_Instance();
		
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