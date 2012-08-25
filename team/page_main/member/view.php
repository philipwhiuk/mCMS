<?php

class Team_Page_Main_Member_View extends Team_Page_Main {

	public function __construct($parent, $team, $member){
		parent::__construct($parent);
		$this->team = $team;
		$this->member = $member;
		
		$team->content();
		$member->content();
		try {
			$member->member()->content();
		} catch (Member_Not_Found_Exception $e) {
		}
	}

	public function display(){
		$system = MCMS::Get_Instance();
		$module = Module::Get('team');
		$template = $system->output()->start(array('team','page','member','view'));		
		$res = Resource::Get_By_Argument(Module::Get('team'),$this->team->id() .'/' . 'view');
		$template->team_url = $system->url($res->url());
		$template->vacant = Language::Retrieve()->get($module, array('misc','vacant'));
		$template->view_info_on_role = Language::Retrieve()->get($module, array('misc','view_info_on_role'));
		
		$template->team_title = $this->team->content()->get_title();
		$template->member_role = $this->member->content()->get_title();
		$template->member_role_body = $this->member->content()->get_body();
		try {
			$template->member_name = $this->member->member()->content()->get_title();
			$template->member_body = $this->member->member()->content()->get_body();
			$template->member = true;
		} catch (Member_Not_Found_Exception $e) {
			$template->member = false;
		}


		return $template;
	}

}
