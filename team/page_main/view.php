<?php

class Team_Page_Main_View extends Team_Page_Main {

	public function __construct($parent, $team){
		parent::__construct($parent);
		if(!$team instanceof Team) {
			$team = Team::Get_By_ID($team);
		}
		Permission::Check(array('team',$team->id()), array('view','edit','add','delete'),'view');
		$team->content();
		$this->team = $team;
		foreach($team->members() as $member){
			$member->content();
			try { 
				$member->member()->content();
			} catch (Member_Not_Found_Exception $e) {			
			}
		}
		$this->teams = $team->children();
		reset($this->teams);
		$this->selected = current($this->teams);
		
		foreach($this->teams as $steam){
			$steam->content();
		}

		$arg = $this->parent->resource()->get_argument();
		if($arg == 'team'){
			$this->parent->resource()->consume_argument();
			$arg = (int) $this->parent->resource()->get_argument();
			if(isset($this->teams[$arg])){
				$this->selected = $this->teams[$arg];
			}			
		}
	}
	
	public function display(){
		$system = MCMS::Get_Instance();
		$module = Module::Get('team');
		$template = $system->output()->start(array('team','page','view'));
		$url = join('/', $this->team->parents()) . '/';

		$template->team = array(
			'title' => $this->team->content()->get_title(),
			'body' => $this->team->content()->get_body()
		);
		$template->position_vacant = Language::Retrieve()->get($module, array('misc','position_vacant'));
		$template->view_info_on_role = Language::Retrieve()->get($module, array('misc','view_info_on_role'));
		$template->members = array();

		foreach($this->team->members() as $member){
			$tMem = array();
			$tMem['role_title'] = $member->content()->get_title();
			$tMem['role_body'] = $member->content()->get_body();
			try {
			$tMem['member_title'] = $member->member()->content()->get_title();
			$tMem['member_body'] = $member->member()->content()->get_body();
			$tMem['member'] = true;			
			} catch(Member_Not_Found_Exception $e) {
			$tMem['member'] = false;
			}
			$tMem['url'] = $system->url(Resource::Get_By_Argument($module, $url . 'member/' . $member->id().'/view')->url());
			$template->members[] = $tMem;
		}

		$template->teams = array();

		foreach($this->team->children() as $team){
			$members = array();
			$selected = false;
			if(isset($this->selected) && $this->selected == $team){
				$selected = true;
			}
			$template->teams[] = array(
				'title' => $team->content()->get_title(),
				'body' => $team->content()->get_body(),
				'members' => $members,
				'selected' => $selected,
				'furl' => $system->url(Resource::Get_By_Argument($module, $url . $team->id())->url()),
				'surl' => $system->url(Resource::Get_By_Argument($module, $url . 'view/team/' . $team->id())->url()),
			);
		}

		if(isset($this->selected) && $this->selected){
			foreach($this->selected->members() as $member){
				$sMem = array();
				$sMem['role_title'] = $member->content()->get_title();
				try {
					$sMem['member_title'] = $member->member()->content()->get_title();
				} catch (Member_Not_Found_Exception $e) {
					$sMem['member_title'] = '';
				}
				$sMem['url'] = $system->url(Resource::Get_By_Argument($module, $url . $this->selected->id() . '/member/' . $member->id() . '/view')->url());
				$template->selected[] = $sMem;
			}
		}

		return $template;
	}

}


