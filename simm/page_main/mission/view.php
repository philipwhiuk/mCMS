<?php
class Simm_Page_Main_Mission_View extends Simm_Page_Main_Mission {
	public function __construct($parent,$mission) {
		$this->mission = $mission;		
		$this->posts = Simm_Mission_Post::Get_By_Mission($mission->id());
		$this->simms = Simm_Mission_Simm::Get_By_Mission($mission->id());		
		$this->check('view');	
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('simm','page','mission','view'));
		$template->id = $this->mission->id();
		try {
		$template->rank['title'] = $this->character->rank()->title();
		} catch(Simm_Rank_Not_Found_Exception $e) {
		$template->rank['title'] = '';
		}
		$template->firstname = $this->character->firstname();
		$template->middlename = $this->character->middlename();
		$template->lastname = $this->character->lastname();	
		$template->age = $this->character->age();
		$template->species = $this->character->species();				
		$template->modes = $this->modes;
		$template->positions = array();
		foreach($this->positions as $position) {
			$tpos = array();		
			$tpos['position'] = $position->manifest_position()->position()->description()->get_title();
			$tpos['department'] = $position->manifest_position()->manifest_department()->department()->description()->get_title();
			$tpos['manifest'] = $position->manifest_position()->manifest_department()->manifest()->description()->get_title();
			$template->positions[] = $tpos;
		}
		$template->contentSections = array();
		foreach($this->contentSections as $section) {
			$tcs = array();
			$tcs['title'] = $section->content()->get_title();
			$tcs['body'] = $section->content()->get_body();			
			$template->contentSections[] = $tcs;
		}
		$template->serviceRecord = array();				
		foreach($this->serviceRecord as $record) {
			$trec = array();
			$trec['title'] = $record->content()->get_title();
			$trec['body'] = $record->content()->get_body();			
			$template->contentSections[] = $tcs;
		}
		$template->posts = array();
		return $template;
	}
}