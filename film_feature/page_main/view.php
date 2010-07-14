<?php

class Film_Feature_Page_Main_View extends Film_Feature_Page_Main {
	
	private $feature;
	
	public function __construct($parent, $feature){
		parent::__construct($parent);
		try {
			$this->feature = $feature;
			$this->feature->get_showings();
			Permission::Check(array('film_feature',$feature->get_id()), array('view','edit','add','delete','list'),'view');
			Module::Get('film_feature')->file('film_feature_impl/page_main/view');
			$this->films = $feature->get_films();
			$this->implViews = array();
			$class = $feature->get_module()->load_section('Film_Feature_Impl_Page_Main_View');
			foreach($this->films as $film) {			
				$this->implViews[] = new $class($film);
			}
		}
		catch(Exception $e) {
			var_dump($e);
		}
	}
	
	public function display(){
		$system = System::Get_Instance();
		$module = Module::Get('film_feature');
		$template = $system->output()->start(array('film_feature','page','view'));
		$template->title = $this->feature->get_content()->get_title();
		$date['mday'] = 0;
		$date['month'] = 0;
		$date['year'] = 0;
		if(count($this->implViews) > 0) {
			try {
				$sIfile = $this->implViews[0]->item->get_film()->get_smallImage()->width(900);
				$template->backgroundImage = $sIfile->file()->url();
			}
			catch (Exception $e) {
			}
		}
		$template->showings = array();
		foreach($this->feature->get_showings() as $showing) {
			$template->showings[] = $showing->get_datetime();
		}
		$template->films = array();
		foreach($this->implViews as $implView) {
			$template->films[] = $implView->display();
		}
		return $template;
	}
}