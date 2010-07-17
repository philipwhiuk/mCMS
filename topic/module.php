<?php
class Topic_Module extends Module {
	public function load(){	
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		$this->files('topic','topic_post','exception');
		Module::Get('admin');
		Admin::Register('topic','Topic_Admin','admin',$this, 0);
	}
}