<?php

class Form_Field_Submit extends Form_Field {
	
	private $label;
	
	public function set_label($label){
		$this->label = $label;
	}
	
	public function execute($parent, $data){ }
	
	public function display($parent){
		$template = System::Get_Instance()->output()->start(array('form','field','submit'));
		
		$id = $parent->get_id();
		$id[] = $this->name;
		
		$template->id = $id;
		
		$template->label = isset($this->label) ? $this->label : null;
		
		return $template;
	}
	
}