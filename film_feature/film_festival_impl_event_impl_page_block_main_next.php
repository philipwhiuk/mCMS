<?php
class Film_Feature_Film_Festival_Impl_Event_Impl_Page_Block_Main_Next extends Film_Festival_Impl_Event_Impl_Page_Block_Main_next {
	function __construct($item) {
		$ffmodule = Module::Get('film_feature');
		$this->item = $item;
		$this->film_feature = $this->item->get_feature();
		$this->id = $this->film_feature->get_id();
		$this->film_feature->get_showings();
		$ffmodule->file('film_feature_impl/film_festival_impl/event_impl/page_block_main/next');
		$this->films = $this->film_feature->get_films();
		$this->implViews = array();
		$class = $this->film_feature->get_module()->load_section('Film_Feature_Impl_Film_Festival_Impl_Event_Impl_Page_Block_Main_next');
		foreach($this->films as $film) {			
			$this->implViews[] = new $class($film);
		}
		$system = System::Get_Instance();
		$this->url = $system->url(Resource::Get_By_Argument($ffmodule, $this->film_feature->get_id())->url());
	}
	function display() {
		$this->system = System::Get_Instance();
		$this->module = Module::Get('event');
		$template = $this->system->output()->start(array('film_feature','film_festival','event','page','block','next'));
		$showingsCount = 0;
		$date = 0;
		foreach($this->film_feature->get_showings() as $showing) {
			$newdate = date('dmY', $showing->get_datetime());
			if($newdate != $date){
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
		$template->id = $this->id;
		$template->url = $this->url;
		return $template;
	}
}
?>