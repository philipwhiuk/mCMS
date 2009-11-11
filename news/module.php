<?php

class News_Module extends Module {
	
	public function load(){
		Module::Get('content');
		
		$this->files('article','category', 'exception');
	}
	
}