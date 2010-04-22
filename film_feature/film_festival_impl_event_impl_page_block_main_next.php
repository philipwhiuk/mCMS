<?php
class Film_Feature_Film_Festival_Impl_Event_Impl_Page_Block_Main_Next extends Film_Festival_Impl_Event_Impl_Page_Block_Main_next {
	function __construct($item) {
		$this->item = $item;
		$this->film_feature = $this->item->get_feature();
		$this->film_feature->get_showings();
		Module::Get('film_feature')->file('film_feature_impl/film_festival_impl/event_impl/page_block_Main/next');
		$this->films = $this->film_feature->get_films();
		$this->implViews = array();
		$class = $this->film_feature->get_module()->load_section('Film_Feature_Impl_Film_Festival_Impl_Event_Impl_Page_Block_Main_next');
		foreach($this->films as $film) {			
			$this->implViews[] = new $class($film);
		}
	}
	function display() {
		$this->system = System::Get_Instance();
		$this->module = Module::Get('event');
		$template = $this->system->output()->start(array('film_feature','film_festival','event','page','block','next'));
		foreach($this->film_feature->get_showings() as $showing) {
			$newdate = getdate($showing->get_datetime());
			if($newdate['mday'] != $date['mday'] | $newdate['month'] != $date['month'] | $newdate['year'] != $date['year']) {
				$date = $newdate;
				$showingsCount++;
				$template->showings[$showingsCount] = array();
				$template->showings[$showingsCount][] = $showing->get_datetime();
			}
			else { 
				$template->showings[$showingsCount][] = $showing->get_datetime();
			}
		}
		foreach($this->implViews as $implView) {
			$template->films[] = $implView->display();
		}
		return $template;
	}
}
?>