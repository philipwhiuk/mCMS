<?php

class Gallery_Module extends Module {

	public function load(){
		$this->files('gallery','item','exception');
	}

}
