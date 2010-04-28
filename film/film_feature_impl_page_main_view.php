<?php

class Film_Film_Feature_Impl_Page_Main_View extends Film_Feature_Impl_Page_Main_View  {
	function __construct($item) {
		$this->item = $item;
		$this->feature = $this->item->get_feature();
		$this->film = $this->item->get_film();
		try {
			$this->smallImageFiles = $this->film->get_smallImage()->files();
		}
		catch(Image_Not_Found_Exception $e) {
		}

		$this->leads = $this->film->get_lead_actors();
		$this->screenplays = $this->film->get_screenplay_writers();
	}
	function display() {
		$this->system = System::Get_Instance();
		$module = Module::Get('film');
		$language = Language::Retrieve();
		$template = $this->system->output()->start(array('film', 'film_feature','page','view'));
		$template->release_year_title = $language->get($module, array('view','release_year'));
		$template->runtime_title = $language->get($module, array('view','runtime'));
		$template->release_year = $this->film->get_release_year();
		$template->runtime = $this->film->get_runtime();
		$template->imdbID = $this->film->get_imdb();
		try {
			$template->director = $this->film->get_director()->get_description()->get_title();
		}
		catch(Actor_Not_Found_Exception $e) {
		}
		$template->certificate = $this->film->get_certificate()->get_image()->description()->get_title();
		try {
				$template->trailer = $this->film->get_random_trailer()->get_video()->content()->get_body();
		}
		catch (Film_Trailer_Not_Found_Exception $e) {
		}
		$template->description = $this->film->get_description()->get_body();
		try {
			$template->tagline = $this->film->get_random_tagline()->text;
		}
		catch (Film_Tagline_Not_Found_Exception $e) {
		}
		if(isset($this->smallImageFiles)) {
			$template->smallImage = $this->smallImageFiles[0]->file()->id();
		}
		$template->leads = array();
		foreach($this->leads as $lead) {
			try {
				$template->leads[] = $lead->get_actor()->get_description()->get_title();
			}
			catch(Actor_Not_Found_Exception $e) {
			}
		}
		$template->screenplays = array();
		foreach($this->screenplays as $screenplay) {
			try {
				$template->screenplays[] = $screenplay->get_actor()->get_description()->get_title();
			}
			catch(Actor_Not_Found_Exception $e) {
			}
		}
		return $template;
	}

}