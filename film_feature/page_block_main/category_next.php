<?php
class Film_Feature_Page_Block_Main_Category_Next extends Film_Feature_Page_Block_Main {
	function __construct($parent, $feature) {
		$this->feature = $feature;
		$this->feature->get_showings();
		Module::Get('film_feature')->file('film_feature_impl//page_block_main/category_next');
		$this->films = $this->feature->get_films();
		$class = $this->feature->get_module()->load_section('Film_Feature_Impl_Page_Block_Main_Category_Next');
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