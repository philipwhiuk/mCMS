<?php
class Film_Feature_Film_Festival_Impl_Event_Impl_Page_Main_View extends Film_Festival_Impl_Event_Impl_Page_Main_View {	
	function __construct($item) {
		$this->item = $item;
		$this->film_feature = $this->item->get_feature();
		$this->film_feature->get_showings();
		Module::Get('film_feature')->file('film_feature_impl/film_festival_impl/event_impl/page_main/view');
		$this->films = $this->film_feature->get_films();
		$this->implViews = array();
		$class = $this->film_feature->get_module()->load_section('Film_Feature_Impl_Film_Festival_Impl_Event_Impl_Page_Main_View');
		foreach($this->films as $film) {			
			$this->implViews[] = new $class($film);
		}
	}
	function display() {
		$this->system = System::Get_Instance();
		$this->module = Module::Get('event');
		$template = $this->system->output()->start(array('film_feature','film_festival','event','page','main','view'));
		$template->title = $this->film_feature->get_content()->get_title();
		$cdate = 0;
		foreach($this->film_feature->get_showings() as $showing) {
			$newdate = date('dmY', $showing->get_datetime());
			$showingsCount = 0;
			if($newdate != $cdate){
				$cdate = $newdate;
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