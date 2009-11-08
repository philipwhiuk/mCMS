<?php

System::Get_Instance()->files('html/output');

class Inline_Output extends HTML_Output {
	
	public function logic($path){		
		return Page::Load($path, true);
	}
	
	public static function Create(){
		return new Inline_Output();	
	}
	
}	