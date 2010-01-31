<?php

class Member_Module extends Module {

	public function load(){
		Module::Get('user');
		
		$this->files('member','exception');
	}

}

