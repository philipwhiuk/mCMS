<?php

class Film_Page_Main_View extends Film_Page_Main {
	
	private $film;
	
	public function __construct($parent, $film){
		parent::__construct($parent);
		$film_module = Module::Get('film');
		$this->film = $film;
		Permission::Check(array('film',$film->get_id()), array('view','edit','add','delete','list'),'view');
		try {
			$this->smallImageFiles = $this->film->get_smallImage()->files();
		}
		catch (Image_Not_Found_Exception $e) {
		}
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
	}
	
	public function display(){
	//	$language = Language::Retrieve();
		$template = System::Get_Instance()->output()->start(array('film','page','view'));
		try {
				$sI =  $this->film->get_smallImage();
				$sIfile = $sI->width(900);			
				$template->backgroundImage = $sIfile->file()->url();
		}
		catch (Exception $e) {
		}
		$template->title = $this->film->get_description()->get_title();
	//	$template->release_year_title = $language->get('film', array('view','release_year'));
	//	$template->runtime_title = $language->get('film', array('view','runtime'));
		$template->release_year = $this->film->get_release_year();
		$template->runtime = $this->film->get_runtime();
		$template->imdbID = $this->film->get_imdb();
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
		if(isset($this->description)) {
			 $template->description = $this->description;
		}
		else {
			$template->description = "";
		}
		if(isset($this->synopsis)) {
			$template->synopsis = $this->synopis;
		}
		else {
			$template->synopsis = "";
		}
		try {
			$template->tagline = $this->film->get_random_tagline()->text();
		}
		catch (Film_Tagline_Not_Found_Exception $e) {
			$template->tagline = "";
		}
		if(isset($this->smallImageFiles)) {
			$template->smallImage = $this->smallImageFiles[0]->file()->id();
		}
		$template->role_actors = $this->role_actors;
		return $template;
	}
}