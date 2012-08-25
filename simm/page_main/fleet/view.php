<?php
class Simm_Page_Main_Fleet_View extends Simm_Page_Main_Fleet {
	public function __construct($parent,$fleet) {
		$this->fleet = $fleet;		
		$this->sfleets = Simm_Fleet::Get_By_Parent($fleet->id());
		$this->simms = Simm_Fleet_Simm::Get_By_Fleet($fleet->id());
		$this->check('view');	
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('simm','page','fleet','view'));
		$template->name = $this->fleet->description()->get_title();
		$template->sfleets = array();
		foreach($this->sfleets as $sfleet) {
			$sData = array();
			$sData['name'] = $sfleet->description()->get_title();
			$sData['shortcode'] = $sfleet->shortcode();
			$sData['url'] = '';
			$template->sfleets[] = $sData;
		}
		$template->simms = array();	
		foreach($this->simms as $simm) {
			try {
			$sData = array();
			$sData['name'] = $simm->simm()->description()->get_title();
			$sData['registry'] = $simm->simm()->registry();
			$sData['specification'] = $simm->simm()->specification()->description()->get_title();
			try {
				$sData['status'] = $simm->simm()->status();
			} catch (Simm_Status_Not_Found_Exception $e) {
				$sData['status'] = '';
			}
			try {
				$sData['format'] = $simm->simm()->format();
			} catch (Simm_Format_Not_Found_Exception $e) {
				$sData['format'] = '';
			}
			try {			
				$sData['rating'] = $simm->simm()->rating();
			} catch (Simm_Rating_Not_Found_Exception $e) {
				$sData['rating'] = '';
			}
			$sData['url'] = '';
			$sData['manifest'] = $simm->simm()->manifest();
			$template->simms[] = $sData;
			} catch (Content_Not_Found_Exception $e) {
			} catch (Simm_Not_Found_Exception $e) {
			}
		}
		return $template;
	}
}