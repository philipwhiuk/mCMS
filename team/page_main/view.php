<?php

class Team_Page_Main_View extends Team_Page_Main {

	public function __construct($parent, $team){
		parent::__construct($parent);
		Permission::Check(array('team',$team->id()), array('view','edit','add','delete'),'view');
		$team->content();
		$this->team = $team;
		foreach($team->members() as $member){
			$member->content();
			$member->member()->content();
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
		$system = System::Get_Instance();
		$module = Module::Get('team');
		$template = $system->output()->start(array('team','page','view'));
		$url = join('/', $this->team->parents()) . '/';

		$template->team = array(
			'title' => $this->team->content()->get_title(),
			'body' => $this->team->content()->get_body()
		);

		$template->members = array();

		foreach($this->team->members() as $member){
			$template->members[] = array(
				'role_title' => $member->content()->get_title(),
				'role_body' => $member->content()->get_body(),
				'member_title' => $member->member()->content()->get_title(),
				'member_body' => $member->member()->content()->get_body(),
				'url' => $system->url(Resource::Get_By_Argument($module, $url . 'team/view/' . $member->id())->url()),
			);
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
				$template->selected[] = array(
					'role_title' => $member->content()->get_title(),
					'member_title' => $member->member()->content()->get_title(),
					'url' => $system->url(Resource::Get_By_Argument($module, $url . $this->selected->id() . '/member/' . $member->id() . '/view')->url()),
				);
			}
		}

		return $template;
	}

}


