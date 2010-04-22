<?php
class Film_Feature_Page_Main_List extends Film_Feature_Page_Main {
	private $features;
	function __construct($parent) {
		parent::__construct($parent);
		$this->features = Film_Feature::Get_All();
		Permission::Check(array('film_feature'), array('view','edit','add','delete','list'),'list');
		$this->groups = array();
		foreach($this->features as $feature) {
			$showings = $feature->get_showings();
			foreach($showings as $showing) {
				$group_prices = $showing->get_group_prices();
				foreach($group_prices as $group_price) {
					if(!isset($this->groups[$group_price->get_group()->get_id()])) {
						$this->groups[$group_price->get_group()->get_id()] = $group_price->get_group();
					}
				}
			}
		}
	}
	function display() {
		$template = System::Get_Instance()->output()->start(array('film_feature','page','list'));
		$language = Language::Retrieve();
		$system = System::Get_Instance();
		$module = Module::Get('film_feature');
		$template->title = $language->get($module, array('list','title'));
		foreach($this->features as $feature) {
			$date['mday'] = 0;
			$date['month'] = 0;
			$date['year'] = 0;
			$f = array();
			$f['title'] = $feature->get_content()->get_title();
			$f['url'] = $system->url(Resource::Get_By_Argument($module, $feature->get_id())->url());
			try {
				$films = $feature->get_films();
				if(count($films) > 0) {
					$sIfile = $films[0]->get_film()->get_smallImage()->width(200);
					$f['smallImage'] = $sIfile->file()->url();
					
				}
			}
			catch(Image_Not_Found_Exception $e) {
			}
			catch(Exception $e) {
				var_dump($e);	
			}
			try {
				$certificate_files = $feature->get_certificate()->get_image()->files();
				$f['certificate_url'] = $certificate_files[0]->file()->url();
				$f['certificate_name'] = $feature->get_certificate()->get_image()->description()->get_title();
			}
			catch(Film_Certificate_Not_Found_Exception $e) {
			}
			
			
			$f['category'] = $feature->get_category()->get_id();
			$showings = array();
			$showingsCount = 0;
			foreach($feature->get_showings() as $showing) {
				if($showing->get_datetime() > time()) {
					$newdate = getdate($showing->get_datetime());
					if($newdate['mday'] != $date['mday'] | $newdate['month'] != $date['month'] | $newdate['year'] != $date['year']) {
						$date = $newdate;
						$showingsCount++;
						$showings[$showingsCount] = array();
						$showings[$showingsCount][$showing->get_id()]['time'] = $showing->get_datetime();
					}
					else { 
						$showings[$showingsCount][$showing->get_id()]['time'] = $showing->get_datetime();
					}
					foreach($this->groups as $group) {
						try {
							$gp = Film_Feature_Showing_Group_Price::Get_By_Showing_Group($showing->get_id(),$group->get_id());
							$showings[$showingsCount][$showing->get_id()]['group_price'][$group->get_id()] = $gp->get_price();
						}
						catch(Film_Feature_Showing_Group_Price_Not_Found_Exception $e) {
						}
					}
				}
			}
			$f['showings'] = $showings;
			$template->features[] = $f;
		}
		foreach($this->groups as $key=>$group) {
			$template->groups[$key] = $group->get_name();
		}
		return $template;
	}
}