<?php 
/**
 * The Video module
 */
class Video_Module extends Module {

	public function load(){
		Module::Get('content');
		$this->files('exception','video');
		try {
			Module::Get('admin');
			Admin::Register('video','Video_Admin','admin',$this);
		} catch(Exception $e){
		}
	}
}
