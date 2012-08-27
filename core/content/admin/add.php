<?php
class Content_Admin_Add extends Content_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->mode = 'add';  
		$language = Language::Retrieve();
		$this->title = $language->get($this->module, array('admin','add','page_title'));
		$this->form = new Form(array('content','add', 'admin'), $this->url('add/'));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','add','title')));
		$title->set_value('');
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','add','body')));
		$body->set_value('');
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','add','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}		
	}	
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('content','admin','add'));
		$template->title = $this->title;
		$template->form = $this->form->display();
		return $template;
	}
}