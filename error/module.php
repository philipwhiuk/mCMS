<?php 
class Error_Module extends Module {
	public function load() {
		Module::Get('permission');
		Module::Get('language');
		$this->files('exception');
	}
}