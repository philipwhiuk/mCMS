<?php
class Simm_Page_Main_Position_View extends Simm_Page_Main_Position {
	public function __construct($parent,$position) {
		$this->position = $position;
		$this->departments = Simm_Department_Position::Get_By_Position($position->id());
		$this->mpos = Simm_Manifest_Position::Get_By_Position($position->id());
		$this->characters = array();
		foreach($this->mpos as $mpos) {
			$this->characters = array_merge($this->characters,Simm_Manifest_Character::Get_By_Manifest_Position($mpos->id()));
		}
		$this->check('view');
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('simm','page','position','view'));
		$template->title = $this->position->description()->get_title();
		$template->description = $this->position->description()->get_body();	
		$template->departments = array();
		foreach($this->departments as $department) {
			try {
				$dData = array();
				$dData['title'] = $department->department()->description()->get_title();
				$dData['url'] = $department->department()->id();
			$template->departments[] = $dData;
			} catch (Simm_Position_Not_Found_Exception $e) {
			
			}
		}
		$template->characters = array();
		foreach($this->characters as $character) {
			$cData = array();
			$cData['fname'] = $character->character()->firstname();
			$cData['mname'] = $character->character()->middlename();
			$cData['lname'] = $character->character()->lastname();	
			try {
				$cData['rank'] = $character->character()->rank()->title();
			} catch (Simm_Rank_Not_Found_Exception $e) {
				$cData['rank'] = '';
			}
			$cData['simm'] = $character->manifest_position()->manifest_department()->manifest()->description()->get_title();	
			$template->characters[] = $cData;
		}
		$template->modes = $this->modes;
		return $template;
	}
}