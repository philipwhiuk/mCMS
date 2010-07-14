<?php

class Content_Page_Main_Edit extends Content_Page_Main {
	
	protected $content;
	
	public function __construct($parent, $content){
		parent::__construct($parent);
		$this->content = $content;
		$language = Language::Retrieve();
		$module = Module::Get('content');
		
		$this->check('edit');		
		
		$this->form = new Form(array('content',$content->id(), 'edit'), $this->parent->url($this->parent->resource()->url()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($module, array('edit','title')));
		$title->set_value($this->content->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($module, array('edit','body')));
		$body->set_value($this->content->get_body());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($module, array('edit','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			$resource = Resource::Get_By_Argument(Module::Get('content'),$content->id() .'/view');
			
			System::Get_Instance()->redirect($this->parent->url($resource->url()));
		} catch(Form_Incomplete_Exception $e){
		}
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('content','page','edit'));
		$template->title = $this->content->get_title();
		$template->form = $this->form->display();
		$template->modes = $this->modes;
		return $template;
	}
}
