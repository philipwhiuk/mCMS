<?php
class Simm_Page_Main_Department_View extends Simm_Page_Main_Department {
	public function __construct($parent,$department) {
		$this->department = $department;
		$this->positions = Simm_Department_Position::Get_By_Department($department->id());
		$this->check('view');	
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('simm','page','department','view'));
		$template->title = $this->department->description()->get_title();
		$template->description = $this->department->description()->get_body();	
		$template->positions = array();
		foreach($this->positions as $position) {
			try {
			$pData['title'] = $position->position()->description()->get_title();
			$pData['description'] = $position->position()->description()->get_body();			
			$template->positions[] = $pData;
			} catch (Simm_Position_Not_Found_Exception $e) {
			
			}
		}
		$template->modes = $this->modes;
		return $template;
	}
}