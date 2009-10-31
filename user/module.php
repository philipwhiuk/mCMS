<?php

class User_Module extends Module {
	
	public function load(){
		$this->files('user','exception');
	}
	
}