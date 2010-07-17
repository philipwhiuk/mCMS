<?php

class Film_Feature_Module extends Module {
	
	public function load(){
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('film_certificate');		
		$this->files('film_feature',
					 'film_feature_category',
					 'film_feature_impl',
					 'film_feature_showing',
					 'film_feature_showing_group_price',
					 'exception');
		Module::Get('admin');
		Admin::Register('film_feature','Film_Feature_Admin','admin',$this);
	}
	
}