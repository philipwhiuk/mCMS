<?php	
class User_Status_Page_Block_Main_Status_View extends User_Status_Page_Block_Main {
	public function __construct($parent,$user) {
		$this->user = $user;
	}
	public function display() {
		$template = System::Get_Instance()->output()->start(array('user_status','page','block','status','view'));
		$template->display_name = ucwords($this->user->get('display_name'));
		return $template;
	}
}
