<?php

class Simm_Module extends Module {
	public function load(){	
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');

		$this->files('specification','deck','auxcraft',
					'specification_technology','specification_category','specification_type',
					'fleet','simm','character','position','department','manifest','rank','status','format','rating',
					'mission','post',
					'fleet_simm','character_biography','character_servicerecord',
					'department_position',
					'manifest_department','manifest_position', 'manifest_character',
					'exception');

		try {
			Module::Get('admin');
			Admin::Register('simm','Simm_Admin','admin',$this);
		} catch(Exception $e){

		}	
	}
}