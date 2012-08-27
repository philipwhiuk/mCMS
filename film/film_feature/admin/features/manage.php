<?php
class Film_Feature_Admin_Features_Manage extends Film_Feature_Admin_Features {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$film_features = Film_Feature::Get_All();
		@usort($film_features,array("Film_Feature_Admin","film_feature_sort"));	
		if(!(($page-1)*20 <= count($film_features))) {
			$page = (int) (count($film_features)/20)-1;
		}
		$this->film_feature = array();
		for($i = ($page-1)*20; $i < $page*20 & $i< count($film_features); $i++) {
			if($film_features[$i] instanceof Film_Feature) { $this->film_features[] = $film_features[$i]; }
		}
		$this->page = $page;
		$count = Film_Feature::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('features/manage/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('film_feature','admin','features','manage'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->film_features as $film_feature){
			$fft = array();
			try {
				$fft['title'] = $film_feature->get_content()->get_title();
			} catch (Content_Not_Found_Exception $e) {
				$fft['title'] = '';
			}
			$fft['edit'] = $this->url('edit/' . $film_feature->get_id());
			$template->film_features[] = $fft;
		}
		return $template;
	}
}