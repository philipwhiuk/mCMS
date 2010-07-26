<?php
class Profile_Module extends Module {
	public function load(){
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('content');
		$this->files('profile',
					 'profile_field',
					 'profile_field_impl','profile_field_profile_impl',
					 'exception');
		try {
			Module::Get('admin');
			Admin::Register('profile','Profile_Admin','admin',$this);
			Profile_Field::Register('Profile_Field_Textbox','profile_field_textbox',$this);
		}
		catch (Exception $e) {
		
		}
	}
}