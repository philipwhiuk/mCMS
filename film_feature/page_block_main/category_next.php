<?php
class Film_Feature_Page_Block_Main_Category_Next extends Film_Feature_Page_Block_Main {
	function __construct($parent, $feature,$cat) {
		$this->feature = $feature;
		$this->feature->get_showings();
		$this->category = $cat;
		Module::Get('film_feature')->file('film_feature_impl/page_block_main/category_next');
		$this->films = $this->feature->get_films();
		$class = $this->feature->get_module()->load_section('Film_Feature_Impl_Page_Block_Main_Category_Next');
		foreach($this->films as $film) {
			$this->implViews[] = new $class($film);
		}
	}
	function display() {
	try {
		$this->system = System::Get_Instance();
		$this->module = Module::Get('film_feature');
		$template = $this->system->output()->start(array('film_feature','page','block','category','next'));
		$template->category = $this->category;
		$featureID = $this->feature->get_id();
		$res = Resource::Get_By_Argument($this->module, $featureID);
		$resurl = $res->url();
		$template->url = $this->system->url($resurl);
		$cdate = 0;
		foreach($this->feature->get_showings() as $showing) {
			$newdate = date('dmY', $showing->get_datetime());
			$showingsCount = 0;
			if($newdate != $cdate) {
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
	catch(Exception $e) {
		var_dump($e);
	}
	}
}