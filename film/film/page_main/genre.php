<?php

class Film_Page_Main_Genre extends Film_Page_Main {
	private $genre;
	private $films = array();
	public function __construct($parent){
		$system = MCMS::Get_Instance();
		parent::__construct($parent);
		$genre = $parent->resource()->get_argument();
		if(!is_numeric($genre)) {
			throw new Film_Genre_Page_Unavailable_Exception();
		}
		$this->genre = Film_Genre::Get_By_Id($genre);
		$genrefilms = Film_Genre_Film::Get_By_Genre($genre);
		foreach($genrefilms as $genrefilm) {
			$film = array();
			$film['title'] = $genrefilm->get_film()->get_description()->get_title();
			try { $film['titleIMG'] = $genrefilm->get_film()->get_smallImage()->width(200)->file()->url(); }
			catch (Image_Not_Found_Exception $ie) {	}
			$film['titleURL'] = $system->url(Resource::Get_By_Argument(Module::Get('film'),$genrefilm->get_film()->get_id())->url());
			$this->films[] = $film;
		}
		Permission::Check(array('film'), array('view','edit','add','delete','list'),'view');
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('film','page','genre'));
		$language = Language::Retrieve();
		$system = MCMS::Get_Instance();
		$module = Module::Get('film');
		$template->title = sprintf($language->get($module, array('genre','title')),$this->genre->get_content()->get_title());
		$template->content = $this->genre->get_content()->get_body();
		$template->films = $this->films;
		return $template;
	}
}