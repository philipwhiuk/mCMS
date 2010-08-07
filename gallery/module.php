<?php

class Gallery_Module extends Module {

	public function load(){
		$this->files('gallery','gallery_item','exception');
		try {
			Module::Get('admin');
			Admin::Register('gallery','Gallery_Admin','admin',$this);
		} catch(Exception $e){

		}
	}

}
