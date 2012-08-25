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
		if(count($this->films) > 0) {
			try {
				$this->smallImage = $this->films[0]->get_film()->get_smallImage();
			}
			catch (Exception $e) {
				unset($this->smallImage);
			}
		}
	}
	function display() {
		$this->system = MCMS::Get_Instance();
		$this->module = Module::Get('event');
		$template = $this->system->output()->start(array('film_feature', 'event','page','block','next'));
		foreach($this->implViews as $implView) {
			$template->films[] = $implView->display();
		}
		if(isset($this->smallImage)) {
			$template->smallImage = $this->smallImage;
		}
		$date = 0;
		$showingsCount = 0;
		foreach($this->feature->get_showings() as $showing) {
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
		$this->ffmod = Module::Get('film_feature');
		$res = Resource::Get_By_Argument($this->ffmod, $this->feature->get_id());
		$template->url = $this->system->url($res->url());
		return $template;
	}

}