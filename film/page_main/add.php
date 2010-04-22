<?php

class Film_Page_Main_Add extends Film_Page_Main {
	
	private $film;
	
	public function __construct($parent){
		parent::__construct($parent);
		$language = Language::Retrieve();
		$module = Module::Get('film');
		
		Permission::Check(array('film'), array('view','edit','add','delete','list'),'add');
		
		$this->form = new Form(array('film', 'add'), $this->parent->url($this->parent->resource()->url()));
		
		$this->title = $language->get($module, array('add', 'title_main'));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($module, array('add','title')));
		
		$description = Form_Field::Create('description', array('richtext','textarea'));
		$description->set_label($language->get($module, array('add','description')));
		
		$director = Form_Field::Create('director', array('textbox'));
		$director->set_label($language->get($module, array('add','director')));
		$certificate = Form_Field::Create('certificate', array('textbox'));
		$certificate->set_label($language->get($module, array('add','certificate')));
		$runtime = Form_Field::Create('runtime', array('textbox'));
		$runtime->set_label($language->get($module, array('add','runtime')));
		$release_year  = Form_Field::Create('release_year', array('textbox'));
		$release_year->set_label($language->get($module, array('add','release_year')));
		$synopsis  = Form_Field::Create('synopsis', array('richtext','textarea'));
		$synopsis->set_label($language->get($module, array('add','synopsis')));
		$smallImage  = Form_Field::Create('smallImage', array('textbox'));
		$smallImage->set_label($language->get($module, array('add','smallImage')));
		$largeImage  = Form_Field::Create('largeImage', array('textbox'));
		$largeImage->set_label($language->get($module, array('add','largeImage')));
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($module, array('add','submit')));
		
		$this->form->fields($title,$description,$synopsis,$director,$certificate,$runtime,$release_year,$smallImage,$largeImage,$submit);
		
		try {
			$data = $this->form->execute();
			$film = Film::Add($data);
			
			$resource = Resource::Get_By_Argument(Module::Get('film'),$content->id() .'/view');
			
			System::Get_Instance()->redirect($this->parent->url($resource->url()));
		} catch(Form_Incomplete_Exception $e){
		}
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('film','page','add'));
		$template->title = $this->title;
		$template->form = $this->form->display();
		return $template;
	}
}