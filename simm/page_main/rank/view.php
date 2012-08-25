<?php
class Simm_Page_Main_Rank_View extends Simm_Page_Main_Rank {
	public function __construct($parent,$rank) {
		$this->rank = $rank;
		$this->characters = Simm_Character::Get_Where('=', array(array('col','rank'), array('u', $rank->id())));
		foreach($this->characters as $character) {
			$this->charpos[$character->id()] = Simm_Manifest_Character::Get_By_Character($character->id());
		}
		$this->check('view');
	}
	public function display() {
		$system = MCMS::Get_Instance();
		$module = Module::Get('simm');			
		$template = MCMS::Get_Instance()->output()->start(array('simm','page','rank','view'));
		$template->title = $this->rank->title();
		$template->characters = array();
		foreach($this->characters as $character) {
			$cData = array();
			$cData['bio_url'] = $system->url(Resource::Get_By_Argument($module,'bio/' . $character->id())->url());
			$cData['fname'] = $character->firstname();
			$cData['mname'] = $character->middlename();
			$cData['lname'] = $character->lastname();	
			$cData['rank'] = $this->rank->title();
			$cData['positions'] = array();
			foreach($this->charpos[$character->id()] as $charpos) {
				$pData = array();
				$pData['position'] = $charpos->manifest_position()->position()->description()->get_title();
				$pData['department'] = $charpos->manifest_position()->manifest_department()->department()->description()->get_title();
				$pData['simm'] = $charpos->manifest_position()->manifest_department()->manifest()->description()->get_title();
				$cData['positions'][] = $pData;
			}
			$template->characters[] = $cData;
		}
		$template->modes = $this->modes;
		return $template;
	}
}