<?php
class Profile_Page_Main_View extends Profile_Page_Main {
	public $fields = array();
	function __construct($user,$parent) {
		$this->user = $user;
	}
	function display() {
		$template = MCMS::Get_Instance()->output()->start(array('profile','page','user','view'));
		$template->title = $this->user->get('display_name');
		// $template->modes = $this->modes;
		return $template;
	}
}