<?php
class Profile_Module extends Module {
	public function load(){
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('content');
		$this->files('exception');
	}
}