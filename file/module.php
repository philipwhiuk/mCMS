<?php

class File_Module extends Module {
	
	public function load(){
		$this->files('exception', 'file');

                try {
                        Module::Get('admin');
                        Admin::Register('file','File_Admin','admin',$this);
                } catch(Exception $e){

                }   

	}
	
}
