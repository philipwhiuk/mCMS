<?php

class File_Module extends Module {
	
	public function load(){
		$this->files('exception', 'file');
	}
	
}