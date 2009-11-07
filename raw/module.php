<?php

class Raw_Module extends Module {
	
	public function load(){
		$this->files('exception', 'raw');
	}
	
}