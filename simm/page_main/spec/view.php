<?php
class Simm_Page_Main_Spec_View extends Simm_Page_Main_Spec {
	public function __construct($parent,$specification) {
		$this->specification = $specification;		
		$this->decks = Simm_Deck::Get_By_Specification($specification->id());
		$this->auxcraft = Simm_AuxCraft::Get_By_Parent($specification->id());
		$this->tech = Simm_Specification_Technology::Get_By_Specification($specification->id());		
		$this->check('view');
		$this->simms = Simm::Get_Where('=', array(array('col','specification'), array('u', $specification->id())));
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('simm','page','spec','view'));
		$template->id = $this->specification->id();
		$template->name = $this->specification->description()->get_title();
		$template->description = $this->specification->description()->get_body();		
		$template->duration = $this->specification->duration();
		$template->resupply = $this->specification->resupply();
		$template->refit = $this->specification->refit();	
		$template->category = $this->specification->category()->description()->get_title();
		$template->type = $this->specification->category()->type()->description()->get_title();	
		$template->cruisevel = $this->specification->cruisevel();				
		$template->maxvel = $this->specification->maxvel();
		$template->emervel = $this->specification->emervel();
		$template->eveltime = $this->specification->eveltime();
		$template->officers = $this->specification->officers();
		$template->enlisted = $this->specification->enlisted();
		$template->passengers = $this->specification->passengers();
		$template->marines = $this->specification->marines();
		$template->evac = $this->specification->evac();
		$template->docking = $this->specification->docking();
		$template->shuttlebays = $this->specification->shuttlebays();
		$template->length = $this->specification->length();
		$template->width = $this->specification->width();
		$template->height = $this->specification->height();
		$template->decks = $this->specification->decks();
		try {
			$template->notes = $this->specification->notes()->get_body();
		} catch(Content_Not_Found_Exception $e) {
			$template->notes = '';
		}
//		$template->image = $this->specification->image();
		$template->active = (bool) $this->specification->active();
		$template->decks = array();
		foreach($this->decks as $deck) {
			$tpos = array();		
			$tpos['position'] = $position->manifest_position()->position()->description()->get_title();
			$tpos['department'] = $position->manifest_position()->manifest_department()->department()->description()->get_title();
			$tpos['manifest'] = $position->manifest_position()->manifest_department()->manifest()->description()->get_title();
			$template->positions[] = $tpos;
		}
		$template->auxcraft = array();
		foreach($this->auxcraft as $section) {
			$tcs = array();
			$tcs['title'] = $section->content()->get_title();
			$tcs['body'] = $section->content()->get_body();			
			$template->contentSections[] = $tcs;
		}
		$template->tech = array();				
		foreach($this->tech as $tech) {
			$trec = array();
			$trec['title'] = $record->content()->get_title();
			$trec['body'] = $record->content()->get_body();			
			$template->contentSections[] = $tcs;
		}
		foreach($this->simms as $simm) {
			$template->simms[] = array('name' => $simm->description()->get_title());
		}
		$template->posts = array();
		return $template;
	}
}