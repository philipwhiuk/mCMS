<?php

class Form_Module extends Module {
	
	public function load(){
		$this->files('form', 'exception', 'field');
		
		Form_Field::Register_All(array(
			array('textbox', 'Form_Field_Textbox', 'field/textbox', $this),
			array('password', 'Form_Field_Password', 'field/password', $this),
			array('submit', 'Form_Field_Submit', 'field/submit', $this),
			array('textarea', 'Form_Field_Textarea', 'field/textarea', $this)
		));
		
	}
	
}