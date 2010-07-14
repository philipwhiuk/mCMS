<?php
class Film_Feature_Page_Block_Main_Coming_Soon extends Film_Feature_Page_Block_Main {
	public function __construct($parent, $features) {
		$this->features = $features;
		foreach($this->features as $feature) {
			$feature->get_showings();
		}
	}
	public function display(){
		$system = System::Get_Instance();
		$template = $system->output()->start(array('film_feature','page','block','coming_soon'));
		$module = Module::Get('film_feature');
		foreach($this->features as $feature) {
			$date['mday'] = 0;
			$date['month'] = 0;
			$date['year'] = 0;
			$f = array();
			$f['title'] = $feature->get_content()->get_title();
			$f['url'] = $system->url(Resource::Get_By_Argument($module, $feature->get_id())->url());
			$showings = array();
			$showingsCount = 0;
			foreach($feature->get_showings() as $showing) {
				$newdate = getdate($showing->get_datetime());
				if($newdate['mday'] != $date['mday'] | $newdate['month'] != $date['month'] | $newdate['year'] != $date['year']) {
					$date = $newdate;
					$showingsCount++;
					$showings[$showingsCount] = array();
					$showings[$showingsCount][] = $showing->get_datetime();
				}
				else { 
					$showings[$showingsCount][] = $showing->get_datetime();
				}
			}
			$f['showings'] = $showings;
			$template->features[] = $f;
		}
		return $template;
	}
}