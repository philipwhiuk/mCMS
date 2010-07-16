<?php

class Film_Page_Main_Language extends Film_Page_Main {
	private $language;
	private $films = array();
	public function __construct($parent){
		$system = System::Get_Instance();
		parent::__construct($parent);
		$language = $parent->resource()->get_argument();
		if(!is_numeric($language)) {
			throw new Film_Language_Page_Unavailable_Exception();
		}
		$this->language = Film_Language::Get_By_Id($language);
		$languagefilms = Film::Get_By_Language($language);
		foreach($languagefilms as $languagefilm) {
			$film = array();
			$film['title'] = $languagefilm->get_description()->get_title();
			try { $film['titleIMG'] = $languagefilm->get_smallImage()->width(200)->file()->url(); }
			catch (Image_Not_Found_Exception $ie) {	}
			$film['titleURL'] = $system->url(Resource::Get_By_Argument(Module::Get('film'),$languagefilm->get_id())->url());
			$this->films[] = $film;
		}
		Permission::Check(array('film'), array('view','edit','add','delete','list'),'view');
	}
	public function display(){
		$template = System::Get_Instance()->output()->start(array('film','page','language'));
		$language = Language::Retrieve();
		$system = System::Get_Instance();
		$module = Module::Get('film');
		$template->title = sprintf($language->get($module, array('language','title')),$this->language->get_content()->get_title());
		$template->content = $this->language->get_content()->get_body();
		$template->films = $this->films;
		return $template;
	}
}