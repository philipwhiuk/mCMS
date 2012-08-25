<?php

class Film_Film_Feature_Impl_Page_Main_FilmList extends Film_Feature_Impl_Page_Main_FilmList  {
	function __construct($item) {
		$this->item = $item;
		$this->feature = $this->item->get_feature();
		$this->film = $this->item->get_film();
		
	}
	function display() {
		try {
			$this->system = MCMS::Get_Instance();
			$module = Module::Get('film');
			$language = Language::Retrieve();
			$template = $this->system->output()->start(array('film', 'film_feature','page','filmlist'));
			$template->title = $this->film->get_description()->get_title();
			$template->release_year = $this->film->get_release_year();
			$template->runtime = $this->film->get_runtime();
			$template->imdbID = $this->film->get_imdb();
			$template->url = $this->system->url(Resource::Get_By_Argument($module, $this->film->get_id()
																 )->url()
									   ); 
		}
		catch(Exception $e) {
			print_r($e);
			exit();
		}
		return $template;
	}

}