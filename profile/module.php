<?php
class Profile_Module extends Module {
	public function load(){
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('content');
		$this->files('profile',
					 'profile_field','profile_field_user',
					 'profile_textbox','profile_textbox_user',
					 'profile_select','profile_select_option','profile_select_user'
					 'exception');
		Module::Get('admin');
		Admin::Register('profile','Profile_Admin','admin',$this);
}