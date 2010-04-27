<?php

class Film_Feature_Event_Impl_Page_Block_Main_Next extends Event_Impl_Page_Block_Main_Next  {
	function __construct($item) {
		$this->item = $item;
		$this->feature = $this->item->feature();
		$this->feature->get_showings();
		Module::Get('film_feature')->file('film_feature_impl/event_impl/page_block_main/next');
		$this->films = $this->feature->get_films();
		$this->implViews = array();
		$class = $this->feature->get_module()->load_section('Film_Feature_Impl_Event_Impl_Page_Block_Main_next');
		foreach($this->films as $film) {			
			$this->implViews[] = new $class($film);
		}
	}
	function display() {
		$this->system = System::Get_Instance();
		$this->module = Module::Get('event');
		$template = $this->system->output()->start(array('film_feature', 'event','page','block','next'));
		foreach($this->implViews as $implView) {
			$template->films[] = $implView->display();
		}
		return $template;
	}

}