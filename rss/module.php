<?php

class RSS_Module extends Module {
	
	public function load(){
		Module::Get('feed');
	}
	
}
