<?php

class Film_Page_Main_Edit extends Film_Page_Main {
	
	private $film;
	
	public function __construct($parent, $film){
		parent::__construct($parent);
		$this->film = $film;
		$language = Language::Retrieve();
		$module = Module::Get('film');
		
		Permission::Check(array('film',$film->get_id()), array('view','edit','add','delete','list'),'edit');
		
		$this->form = new Form(array('film',$film->get_id(), 'edit'), $this->parent->url($this->parent->resource()->url()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($module, array('edit','title')));
		$title->set_value($this->film->get_description()->get_title());
		
		$description = Form_Field::Create('description', array('richtext','textarea'));
		$description->set_label($language->get($module, array('edit','description')));
		$description->set_value($this->film->get_description()->get_body());
		
		$release_year = Form_Field::Create('release_year', array('textbox'));
		$release_year->set_label($language->get($module, array('edit','release_year')));
		$release_year->set_value($this->film->get_release_year());

		$synopsis = Form_Field::Create('synopsis', array('richtext','textarea'));
		$synopsis->set_label($language->get($module, array('edit','synopsis')));
		$synopsis->set_value($this->film->get_synopsis()->get_body());

		if($this->film->get_largeImage() != 0) {
			$largeImageID = $this->film->get_largeImage()->id();
		}
		else {
			$largeImageID = 0;
		}
		
		$largeImage = Form_Field::Create('largeImage', array('textbox'));
		$largeImage->set_label($language->get($module, array('edit','largeImage')));
		$largeImage->set_value($largeImageID);
		
		if($this->film->get_smallImage() != 0) {
			$smallImageID = $this->film->get_smallImage()->id();
		}
		else {
			$smallImageID = 0;
		}
		
		$smallImage = Form_Field::Create('smallImage', array('textbox'));
		$smallImage->set_label($language->get($module, array('edit','smallImage')));
		$smallImage->set_value($smallImageID);

		$runtime = Form_Field::Create('runtime', array('textbox'));
		$runtime->set_label($language->get($module, array('edit','runtime')));
		$runtime->set_value($this->film->get_runtime());

		$imdb = Form_Field::Create('imdb', array('textbox'));
		$imdb->set_label($language->get($module, array('edit','imdb')));
		$imdb->set_value($this->film->get_imdb());
		
		$certificate = Form_Field::Create('certificate', array('textbox'));
		$certificate->set_label($language->get($module, array('edit','certificate')));
		$certificate->set_value($this->film->get_certificate()->get_id());
			
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($module, array('edit','submit')));
		
		$this->form->fields($title,$description,$release_year,$synopsis,$largeImage,$smallImage,$runtime,$imdb,$certificate,$submit);
		
		try {
			$data = $this->form->execute();
			$this->film->update($data);
			
			$resource = Resource::Get_By_Argument(Module::Get('film'),$film->get_id() .'/edit');
			
			System::Get_Instance()->redirect($this->parent->url($resource->url()));
		} catch(Form_Incomplete_Exception $e){
		}
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('content','page','edit'));
		$template->title = $this->film->get_description()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
}