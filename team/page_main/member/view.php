<?php

class Team_Page_Main_Member_View extends Team_Page_Main {

	public function __construct($parent, $team, $member){
		parent::__construct($parent);
		$this->team = $team;
		$this->member = $member;
		
		$team->content();
		$member->content();
		$member->member()->content();
	}

	public function display(){
		$system = System::Get_Instance();
		$module = Module::Get('team');
		$template = $system->output()->start(array('team','page','member','view'));		
		$url = join('/', $this->team->parents()) . '/';

		$template->team_title = $this->team->content()->get_title();
		$template->member_role = $this->member->content()->get_title();
		$template->member_name = $this->member->member()->content()->get_title();
		$template->member_role_body = $this->member->content()->get_body();
		$template->member_body = $this->member->member()->content()->get_body();



		return $template;
	}

}
