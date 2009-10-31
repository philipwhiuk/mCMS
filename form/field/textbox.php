<?php

class Form_Field_Textbox extends Form_Field {
	
	private $label;
	private $error = false;
	
	public function set_label($label){
		$this->label = $label;
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
		$template = System::Get_Instance()->output()->start(array('form','field','textbox'));
		
		$id = $parent->get_id();
		$id[] = $this->name;
		
		$template->id = $id;
		$template->error = $this->error;
		$template->label = isset($this->label) ? $this->label : null;
		
		return $template;
	}
	
}