<?php

class Film_Festival_Event_Impl_Page_Block_Main_Next extends Event_Impl_Page_Block_Main_Next  {
	function __construct($item) {
		$this->item = $item;
		$this->film_festival = $this->item->get_festival();
		Module::Get('film_festival')->file('film_festival_impl/event_impl/page_block_Main/next');
		$this->features = $this->film_festival->get_features();
		$this->implViews = array();
		$this->featureNames = array();
		$class = $this->film_festival->get_module()->load_section('Film_Festival_Impl_Event_Impl_Page_Block_Main_next');
		foreach($this->features as $feature) {			
			$this->implViews[] = new $class($feature);
			$this->featureNames[] = $feature->get_feature()->get_content()->get_title();
		}
	}
	function display() {
		$this->system = System::Get_Instance();
		$this->module = Module::Get('event');
		$template = $this->system->output()->start(array('film_festival','event','page','block','next'));
		foreach($this->implViews as $implView) {
			$template->features[] = $implView->display();
		}
		$template->featureNames = $this->featureNames;
		$template->title = $this->film_festival->get_content()->get_title();
		return $template;
	}

}