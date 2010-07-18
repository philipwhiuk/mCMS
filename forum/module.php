<?php
class Forum_Module extends Module {
	public function load(){	
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('topic');
		$this->files('forum','forum_topic','exception');
		Module::Get('admin');
		Admin::Register('forum','Forum_Admin','admin',$this, 0);
	}
}