<?php

class Form_Field_Select extends Form_Field {
	
	private $label;
	private $options;
	private $default;
	
	public function set_label($label){
		$this->label = $label;
	}

	public function set_option($value, $label, $default = false){
		if(isset($options[$value])){
			throw new Form_Field_Select_Value_Exists_Exception($this);
		}
		$this->options[$value] = array('label' => $label, 'value' => $value);
		if($default){
			$this->value = $value;
		}
	}
	
	public function execute($parent, $data){
		if(!isset($data) || !isset($this->options[$data])){
			$this->error = true;
			throw new Form_Field_Select_Invalid_Exception($this, null);
		}
		
		return $this->options[$data]['value'];
	}
	
	public function display($parent){
		$template = System::Get_Instance()->output()->start(array('form','field','select'));
		
		$id = $parent->get_id();
		$id[] = $this->name;
		
		$template->id = $id;
		
		$template->label = isset($this->label) ? $this->label : null;
		$template->options = $this->options;
		
		return $template;
	}
	
}
