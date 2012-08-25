<?php
class Simm_Page_Main_Manifest_View extends Simm_Page_Main {
	public function __construct($parent,$manifest) {
		$this->manifest = $manifest;
		$this->departments = Simm_Manifest_Department::Get_By_Manifest($manifest->id());
		$this->positions = array();
		$this->characters = array();
		foreach($this->departments as $department) {
			$this->positions[$department->id()] = Simm_Manifest_Position::Get_By_Manifest_Department($manifest->id());
			foreach($this->positions[$department->id()] as $position) {
				$this->characters[$position->id()] = Simm_Manifest_Character::Get_By_Manifest_Position($position->id());
			}
		}
		$this->checkManifestModes('view');	
	}
	public function display() {
		$system = MCMS::Get_Instance();
		$module = Module::Get('simm');		
		$template = MCMS::Get_Instance()->output()->start(array('simm','page','manifest','view'));
		$template->title = $this->manifest->description()->get_title();
		$template->description = $this->manifest->description()->get_body();		
		$template->roster = array();
		foreach($this->departments as $department) {
			$dData = array();
			$dData['id'] = $department->department()->id();
			$dData['title'] = $department->department()->description()->get_title();
			$dData['positions'] = array();
			foreach($this->positions[$department->id()] as $position) {
				$pData = array();
				$pData['title'] = $position->position()->description()->get_title();
				$pData['default_rank'] = $position->position()->default_rank()->title();
				$pData['count_open'] = $position->count_open();
				$pData['characters'] = array();
				foreach($this->characters[$position->id()] as $crewmember) {
					$cData = array();
					$cData['firstname'] = $crewmember->character()->firstname();
					$cData['middlename'] = $crewmember->character()->middlename();
					$cData['lastname'] = $crewmember->character()->lastname();
					$cData['bio_url'] = $system->url(Resource::Get_By_Argument($module,'bio/' . $crewmember->character()->id())->url());
					try {					
						$cData['rank'] = $crewmember->character()->rank()->title();
					} catch (Simm_Rank_Not_Found_Exception $e) {
						$cData['rank'] = $pData['default_rank'];
					}
					$pData['characters'][] = $cData;
					
				}
				$dData['positions'][] = $pData;
			}
			$template->roster[] = $dData;
			
		}
		$template->modes = $this->modes;
		return $template;
	}
}