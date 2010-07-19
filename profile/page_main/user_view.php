<?php
class Profile_Page_Main_User_View extends Profile_Page_Main {
	public $fields = array();
	function __construct($profile,$parent) {
		$this->profile = $profile;
		$this->profile->user();
		$this->fields = $this->profile->fields();
		$this->usernamefield = $this->profile->field('username');
		foreach($this->fields as $field) {
			try {
				$field->content();
				$field->field();
			}
			catch (Exception $e) {
				var_dump($e);
			}
		}
	}
	function display() {
		$template = System::Get_Instance()->output()->start(array('profile','page','user','view'));
		$template->title = $this->usernamefield->field()->display_view($this->profile->id());
		// $template->modes = $this->modes;
		foreach($this->fields as $field) {
			$f = array();
			$f['title'] = $field->content()->get_title();
			$f['description'] = $field->content()->get_body();
			$f['template'] = $field->field()->display_view($this->profile->id());
			$template->fields[] = $f;
		}
		return $template;
	}
}