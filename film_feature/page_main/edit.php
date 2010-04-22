<?php

class Film_Feature_Page_Main_Edit extends Film_Feature_Page_Main {
	
	private $film_feature;
	
	public function __construct($parent, $film_feature){
		parent::__construct($parent);
		$this->film_feature = $film_feature;
		$language = Language::Retrieve();
		$module = Module::Get('film_feature');
		
		Permission::Check(array('film_feature',$film_feature->get_id()), array('view','edit','add','delete','list'),'edit');
		
		$this->form = new Form(array('film_feature',$film_feature->get_id(), 'edit'), $this->parent->url($this->parent->resource()->url()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($module, array('edit','title')));
		$title->set_value($this->film_feature->get_content()->get_title());
		
		$body = Form_Field::Create('synopsis', array('richtext','textarea'));
		$body->set_label($language->get($module, array('edit','synopsis')));
		$body->set_value($this->film_feature->get_content()->get_body());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($module, array('edit','submit')));
		
		$this->form->fields($title,$body, $submit);

		try {
			$data = $this->form->execute();
		
			$this->film_feature->update($data);
		
			$resource = Resource::Get_By_Argument(Module::Get('film_feature'),$film_feature->get_id() .'/view');
		
			System::Get_Instance()->redirect($this->parent->url($resource->url()));
		} catch(Form_Incomplete_Exception $e){
			
		}
		
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('film_feature','page','edit'));
		$template->title = $this->film_feature->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
}
