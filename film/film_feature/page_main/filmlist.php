<?php

class Film_Feature_Page_Main_FilmList extends Film_Feature_Page_Main {
	
	private $feature;
	
	public function __construct($parent, $feature){
		parent::__construct($parent);
		$this->feature = $feature;
		$this->feature->get_showings();
		Permission::Check(array('film_feature',$feature->get_id()), array('view','edit','add','delete','list'),'edit');
		Module::Get('film_feature')->file('film_feature_impl/page_main/filmlist');
		$this->films = $feature->get_films();
		$this->implViews = array();
		$class = $feature->get_module()->load_section('Film_Feature_Impl_Page_Main_FilmList');
		foreach($this->films as $film) {			
			$this->implViews[] = new $class($film);
		}
	}
	
	public function display(){
		$system = MCMS::Get_Instance();
		$module = Module::Get('film_feature');
		$template = $system->output()->start(array('film_feature','page','filmlist'));
		$template->title = $this->feature->get_content()->get_title();
		$template->films = array();
		foreach($this->implViews as $implView) {
			$template->films[] = $implView->display();
		}
		return $template;
	}
}