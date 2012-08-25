<?php

class Film_Feature_Event_Impl_Page_Main_View extends Event_Impl_Page_Main_View  {
	function __construct($item) {
		$this->item = $item;
		$this->feature = $this->item->feature();
		$this->feature->get_showings();
		Module::Get('film_feature')->file('film_feature_impl/event_impl/page_main/view');
		$this->films = $this->feature->get_films();
		$this->implViews = array();
		$class = $this->feature->get_module()->load_section('Film_Feature_Impl_Event_Impl_Page_Main_View');
		foreach($this->films as $film) {			
			$this->implViews[] = new $class($film);
		}
	}
	function display() {
		$this->system = MCMS::Get_Instance();
		$template = $this->system->output()->start(array('film_feature', 'event','page','view'));
		foreach($this->implViews as $implView) {
			$template->films[] = $implView->display();
		}
		return $template;
	}

}