<?php

class Content_Module extends Module {
	
	public function load(){
		$this->files('content','exception');
	}
	
}