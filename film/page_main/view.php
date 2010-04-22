<?php

class Film_Page_Main_View extends Film_Page_Main {
	
	private $film;
	
	public function __construct($parent, $film){
		parent::__construct($parent);
		$this->film = $film;
		Permission::Check(array('film',$film->get_id()), array('view','edit','add','delete','list'),'view');
		$this->leads = $this->film->get_lead_actors();
		try {
			$this->smallImageFiles = $this->film->get_smallImage()->files();
		}
		catch (Image_Not_Found_Exception $e) {
		}
	}
	
	public function display(){
//		$language = Language::Retrieve();
		$template = System::Get_Instance()->output()->start(array('film','page','view'));
		$template->title = $this->film->get_description()->get_title();
//		$template->release_year_title = $language->get('film', array('view','release_year'));
//		$template->runtime_title = $language->get('film', array('view','runtime'));
		$template->release_year = $this->film->get_release_year();
		$template->runtime = $this->film->get_runtime();
		$template->imdbID = $this->film->get_imdb();
		$template->certificate = $this->film->get_certificate()->get_image()->description()->get_title();
		try {
		$template->director = $this->film->get_director()->get_description()->get_title();
		}
		catch(Actor_Not_Found_Exception $e) {
		}
		try {
			$template->trailer = $this->film->get_random_trailer()->get_video()->content()->get_body();
		}
		catch(Film_Trailer_Not_Found_Exception $e) {
		}
		$template->description = $this->film->get_description()->get_body();
		try {
			$template->tagline = $this->film->get_random_tagline()->text;
		}
		catch (Film_Tagline_Not_Found_Exception $e) {
		}	
		$template->leads = array();
		if(isset($this->smallImageFiles)) {
			$template->smallImage = $this->smallImageFiles[0]->file()->id();
		}
		foreach($this->leads as $lead) {
			$template->leads[] = $lead->get_actor()->get_description()->get_title();
		}
		return $template;
	}
}