<?php	
class User_Status_Page_Block_Main_Status_View extends User_Status_Page_Block_Main {
	public function __construct($parent,$user) {
		$this->user = $user;
	}
	public function display() {
		$system = System::Get_Instance();
		$logoutmodule = Module::Get('logout');
		$profilemodule = Module::Get('profile');
		$template = $system->output()->start(array('user_status','page','block','status','view'));
		$template->display_name = $this->user->get('display_name');
		try {
			$template->profile_url = $system->url(Resource::Get_By_Argument($profilemodule,  $this->user->get_id())->url());
		}
		catch(Exception $e) {
		}
		$template->logout_url = $system->url(Resource::Get_By_Argument($logoutmodule, '')->url());
		return $template;
	}
}
