<?php

class Film_Film_Feature_Impl_Page_Main_View extends Film_Feature_Impl_Page_Main_View  {
	private $language;
	
	function __construct($item) {
		$film_module = Module::Get('film');
		$this->item = $item;
		$this->feature = $this->item->get_feature();
		$this->film = $this->item->get_film();
		try {
			$this->smallImageFiles = $this->film->get_smallImage()->files();
		}
		catch(Image_Not_Found_Exception $e) {
		}
		$cdate = 0;
		$actors = $this->film->get_role_actors();
		$this->role_actors = array();
		$system = System::Get_Instance();
		$actor_module = Module::Get('actor');
		foreach($actors as $actor) {
			$this->role_actors[$actor->get_film_role()->get_content()->get_title()][] = array(
				'name' => $actor->get_actor()->get_description()->get_title(), 
				'url' => $system->url(Resource::Get_By_Argument($actor_module, $actor->get_actor()->get_id())->url())
			);
		}
		$genres = $this->film->get_genres();
		$this->genres = array();
		foreach($genres as $genre) {
			$this->genres[] = array(
				'name' => $genre->get_genre()->get_content()->get_title(),
				'url'=> $system->url(
					Resource::Get_By_Argument(
						$film_module,
						'genre/'.
						$genre->get_genre()->get_id())->url())
			);
		}
		try {
			$this->language = $this->film->get_language()->get_content()->get_title();
		}
		catch(Film_Language_Not_Found_Exception $e) {
		}
		try {
			$this->synopis = $this->film->get_synopsis()->get_body();
		}
		catch(Exception $e) {
			$this->synopis = "";
		}
		try {
			$this->description = $this->film->get_description()->get_body();
		}
		catch(Exception $e) {
			$this->description = "";
		}
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
		$template->role_actors = $this->role_actors;
		$template->genres = $this->genres;
		$template->language = $this->language;
		try {
			$template->certificate = $this->film->get_certificate()->get_image()->description()->get_title();
		}
		catch(Film_Certificate_Not_Found_Exception $e) {
		}
		try {
				$template->trailer = $this->film->get_random_trailer()->get_video()->content()->get_body();
		}
		catch (Film_Trailer_Not_Found_Exception $e) {
		}
		$template->description = $this->description;
		$template->synopsis = $this->synopis;
		try {
			$template->tagline = $this->film->get_random_tagline()->text();
		}
		catch (Film_Tagline_Not_Found_Exception $e) {
		}
		if(isset($this->smallImageFiles)) {
			$template->smallImage = $this->smallImageFiles[0]->file()->id();
		}
		return $template;
	}

}