<?php

class Film_Film_Feature_Impl_Film_Festival_Impl_Event_Impl_Page_Main_View extends Film_Feature_Impl_Film_Festival_Impl_Event_Impl_Page_Main_View  {
	function __construct($item) {
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
			$largeImageFile = $this->film->get_largeImage()->files();
			$this->largeImageURL = $largeImageFile[0]->file()->url();
		}
		catch (Exception $e) {
			$this->largeImageURL = "";
		}
	}
	function display() {
		$this->system = System::Get_Instance();
		$module = Module::Get('film');
		$language = Language::Retrieve();
		$template = $this->system->output()->start(array('film', 'film_feature','film_festival','event','page','main','view'));
		$template->title = $this->film->get_description()->get_title();
		$template->release_year_title = $language->get($module, array('view','release_year'));
		$template->runtime_title = $language->get($module, array('view','runtime'));
		$template->release_year = $this->film->get_release_year();
		$template->runtime = $this->film->get_runtime();
		$template->imdbID = $this->film->get_imdb();
		$template->video = $this->videoContent;
		$template->largeImageURL = $this->largeImageURL;
		return $template;
	}

}