<?php
class File_Admin_Edit extends File_Admin {
	public function __construct($a,$b){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->file = File::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('file',$this->file->id(), 'admin'), $this->url('edit/' . $this->file->id()));
		
		$name = Form_Field::Create('name', array('textbox'));
		$name->set_label($language->get($this->module, array('admin','edit','name')));
		$name->set_value($this->file->name());

		$mime = Form_Field::Create('mime', array('textbox'));
		$mime->set_label($language->get($this->module, array('admin','edit','mime')));
		$mime->set_value($this->file->mime());

		$size = Form_Field::Create('size', array('textbox'));
		$size->set_label($language->get($this->module, array('admin','edit','size')));
		$size->set_value($this->file->size());

		$time = Form_Field::Create('time', array('textbox'));
		$time->set_label($language->get($this->module, array('admin','edit','time')));
		$time->set_value($this->file->time());

		$path = Form_Field::Create('path', array('textbox'));
		$path->set_label($language->get($this->module, array('admin','edit','path')));
		$path->set_value($this->file->path());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($name,$mime,$size,$path,$submit);
		
		try {
			$data = $this->form->execute();
			
			$this->file->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	}
	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('file','admin','edit'));
		$template->title = $this->file->name();
		$template->form = $this->form->display();
		return $template;
	}