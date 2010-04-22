<?php
class Event_Module extends Module {
	function load( ) {
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('content');
		Module::Get('image');
		$this->files('event','event_impl','exception');
	}
}