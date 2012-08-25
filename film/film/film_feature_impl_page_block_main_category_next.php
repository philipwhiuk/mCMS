<?php
class Film_Film_Feature_Impl_Page_Block_Main_Category_Next extends Film_Feature_Impl_Page_Block_Main_Category_Next {
	public function __construct($item) {
		$this->item = $item;
		$this->feature = $this->item->get_feature();
		$this->film = $this->item->get_film();
		try {
			$this->trailer = $this->film->get_random_trailer();
			$this->videoContent = $this->trailer->get_video()->content()->get_body();
		}
		catch (Exception $e) {
			$this->trailer = NULL;
			$this->videoContent = "";
		}
		try {
			$this->certificate = $this->film->get_certificate()->get_image()->description()->get_title();
		}
		catch (Film_Certificate_Not_Found_Exception $e){ 
			$this->certificate = "";
		}
	}
	public function display() {
		$this->system = MCMS::Get_Instance();
		$module = Module::Get('film');
		$language = Language::Retrieve();
		$template = $this->system->output()->start(array('film', 'film_feature','page','block','category','next'));
		$template->release_year_title = $language->get($module, array('view','release_year'));
		$template->runtime_title = $language->get($module, array('view','runtime'));
		$template->release_year = $this->film->get_release_year();
		$template->runtime = $this->film->get_runtime();
		$template->imdbID = $this->film->get_imdb();
		$template->video = $this->videoContent;
		$template->name = $this->film->get_description()->get_title();
		$template->certificate = $this->certificate;
		return $template;
	}
}