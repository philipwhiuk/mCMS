<?php

class TinyMCE_Module extends Module {
	
	public function load(){
		Module::Get('form', 'inline', 'file', 'image');
		
		Form_Field::Register('richtext', 'TinyMCE_Field', 'field', $this);
		
	}
	
}