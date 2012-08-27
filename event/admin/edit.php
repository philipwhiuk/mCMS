<?php
class Event_Admin_Edit extends Event_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->event = Event::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('event',$this->event->get_id(), 'admin'), $this->url('edit/' . $this->event->get_id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->event->get_content()->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		$body->set_value($this->event->get_content()->get_body());
		
		$starttime = Form_Field::Create('starttime', array('textbox'));
		$starttime->set_label($language->get($this->module, array('admin','edit','starttime')));
		$starttime->set_value($this->event->get_starttime());
		
		$finishtime = Form_Field::Create('finishtime', array('textbox'));
		$finishtime->set_label($language->get($this->module, array('admin','edit','finishtime')));
		$finishtime->set_value($this->event->get_finishtime());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$body,$starttime,$finishtime, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->event->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	}

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('event','admin','edit'));
		$template->title = $this->event->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
}