<?php 

class Video_Module extends Module {

	public function load(){
		Module::Get('content');
		$this->files('exception','video');
	}
}
