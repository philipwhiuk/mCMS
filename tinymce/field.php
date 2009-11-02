<?php

class TinyMCE_Field extends Form_Field {
	
	private $label;
	private $error = false;
	private $value = '';
	
	public function set_label($label){
		$this->label = $label;
	}
	
	public function set_value($value){
		$this->value = $value;
	}
	
	public function execute($parent, $data){
		if(!isset($data)){
			$this->error = true;
			throw new Form_Field_Textbox_Invalid_Exception($this, null);
		}
		
		$this->value = (string) $data;
		return (string) $data;
	}
	
	public function display($parent){
		$template = System::Get_Instance()->output()->start(array('tinymce'));
		
		$id = $parent->get_id();
		$id[] = $this->name;
		
		$template->id = $id;
		$template->error = $this->error;
		$template->value = $this->value;
		$template->label = isset($this->label) ? $this->label : null;
		
		return $template;
	}
	
}