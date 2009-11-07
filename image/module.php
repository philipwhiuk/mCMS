<?php

class Image_Module extends Module {
	
	public function load(){
		Module::Get('file');
		$this->files('exception', 'image', 'file');
	}
	
}