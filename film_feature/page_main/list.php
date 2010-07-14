<?php
class Film_Feature_Page_Main_List extends Film_Feature_Page_Main {
	private $showings;
	private $groups = array();
	function __construct($parent) {
	try {
		$system = System::Get_Instance();
		$module = Module::Get('film_feature');
		parent::__construct($parent);
		Permission::Check(array('film_feature'), array('view','edit','add','delete','list'),'list');
		$arg = $parent->resource()->get_argument();
		if(is_numeric($arg)) {
			$first = mktime(0,0,0,1,1,$arg);
			$last = mktime(0,0,0,12,31,$arg);
			$this->title = $arg;
		}
		else {
			switch($arg){
				case "archive":
					$first = 0;
					$last = time();
					$this->title = "archive";
					break;
				default:
				case "current":
					$first = time();
					$last = strtotime("+1 year");
					$this->title = "current";
			}
		}
		$this->showings = Film_Feature_Showing::Get_Period($first,$last);
		// var_dump($this->showings);
		// Make Arrays
		$arrayFeatures = array();
		$arrayShowings = array();
		
		// Build Arrays
		foreach($this->showings as $showing){
			$arrayFeatures[$showing->feature_id()] = $showing->feature_id();
			$arrayShowings[$showing->get_id()] = $showing->get_id();
		}
		// Retrieve Data
		$features = Film_Feature::Get_By_ID($arrayFeatures);
		$groupPrices = Film_Feature_Showing_Group_Price::Get_By_Showing($arrayShowings);
		// Merge Into
		foreach($this->showings as $showing) {
			$showing->feature = $features[$showing->feature_id()];
			$showing->groupPrice = array();
			if(isset($groupPrices[$showing->get_id()])) {
				foreach($groupPrices[$showing->get_id()] as $groupPrice) {
					if(!isset($this->groups[$groupPrice->get_group_id()])) {
						$this->groups[$groupPrice->get_group_id()] = $groupPrice->get_group();
						}
					$showing->groupPrice[$groupPrice->get_group_id()] = $groupPrice;
				}
			}
		}
		$cdate = 0;
		$cfeature = 0;
		$this->items = array();
		foreach($this->showings as $showing) {
			$newdate = date('dmY', $showing->get_datetime());
			if($newdate != $cdate || $showing->feature_id() != $cfeature){
				if(isset($i)) {
					$i++;
				}
				else {
					$i=0;
				}
				$cdate = $newdate;
				$cfeature = $showing->feature_id();
				$item['title'] = $showing->feature->get_content()->get_title();
				$item['url'] = $system->url(Resource::Get_By_Argument($module, $showing->feature->get_id())->url());
				$films = $showing->feature->get_films();
				if(count($films) > 0) {
					try {
						$sIfile = $films[0]->get_film()->get_smallImage()->width(200);
						$item['smallImage'] = $sIfile->file()->url();
					}
					catch (Exception $e) {
						unset($item['smallImage']);
					}
				}
				try {
					$certificate_files = $showing->feature->get_certificate()->get_image()->files();
					$item['certificate_url'] = $certificate_files[0]->file()->url();
					$item['certificate_name'] = $showing->feature->get_certificate()->get_image()->description()->get_title();
				}
				catch(Film_Certificate_Not_Found_Exception $e) {
				}
				$item['category'] = $showing->feature->get_category()->get_id();
				$this->items[$i] = $item;
			}
			$this->items[$i]['showings'][$showing->get_id()]['time'] = $showing->get_datetime();
			foreach($showing->groupPrice as $groupPrice) {
				$this->items[$i]['showings'][$showing->get_id()]['price'][$groupPrice->get_group_id()] = $groupPrice->get_price();
			}
		}
	} catch (Exception $e) {
		var_dump($e);
	}
	}
	function display() {
		$system = System::Get_Instance();
		$template = $system->output()->start(array('film_feature','page','list'));
		$language = Language::Retrieve();
		$module = Module::Get('film_feature');
		try {
		if(is_numeric($this->title)) {
			$template->title = $language->get($module, array('list','title','year'))." ".$this->title;
		}
		else {
			$template->title = $language->get($module, array('list','title',$this->title));
		}
		} catch (Exception $e) {
			var_dump($e);
		}
		$template->items = $this->items;
		$template->groups = array();
		foreach($this->groups as $group) {
			$template->groups[$group->get_id()] = $group->get_name();
		}
		return $template;
	}
}
