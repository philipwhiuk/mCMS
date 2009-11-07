<?php

class Raw_Output extends Output {
		
	public function __construct(){
		
	}
	
	public static function Create(){
		
		return new Raw_Output();
		
	}
	
	public function render($raw){
		header('Content-type: ' . $raw->mimetype());
		echo $raw->output();
	}
	
	public function logic($path){		
		return Raw::Load($path);
	}
	
}