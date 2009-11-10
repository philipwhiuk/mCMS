<?php

class Content_Page_Main_Add extends Content_Page_Main {
	
	private $content;
	
	public function __construct($parent){
		parent::__construct($parent);
		$language = Language::Retrieve();
		$module = Module::Get('content');
		
		Permission::Check(array('content'), array('view','edit','add','delete','list'),'add');
		
		$this->form = new Form(array('content', 'add'), $this->parent->url($this->parent->resource()->url()));
		
		$this->title = $language->get($module, array('add', 'title_main'));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($module, array('add','title')));
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($module, array('add','body')));
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($module, array('add','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			$content = Content::Add($data);
			
			$resource = Resource::Get_By_Argument(Module::Get('content'),$content->id() .'/view');
			
			System::Get_Instance()->redirect($this->parent->url($resource->url()));
		} catch(Form_Incomplete_Exception $e){
		}
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('content','page','add'));
		$template->title = $this->title;
		$template->form = $this->form->display();
		return $template;
	}
}