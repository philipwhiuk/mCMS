<?php
class Simm_Admin_Overview extends Simm_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$language = Language::Retrieve();
		$this->title = $language->get($this->module, array('admin','overview','title'));
		$this->characters = array(
			'url' => $this->url().'characters/',
			'count' => Simm_Character::Count_All(), 
			'title' => $language->get($this->module, array('admin','overview','characters'))
			);
		$this->positions = array(
			'url' => $this->url().'positions/',
			'count' => Simm_Position::Count_All(), 
			'title' => $language->get($this->module, array('admin','overview','positions'))
			);
		$this->departments = array(
			'url' => $this->url().'departments/',
			'count' => Simm_Department::Count_All(), 
			'title' => $language->get($this->module, array('admin','overview','departments'))
			);
		$this->simms = array(
			'url' => $this->url().'simms/',
			'count' => Simm::Count_All(), 
			'title' => $language->get($this->module, array('admin','overview','simms'))
			);
		$this->fleets = array(
			'url' => $this->url().'fleets/',
			'count' => Simm_Fleet::Count_All(), 
			'title' => $language->get($this->module, array('admin','overview','fleets'))
			);
		$this->missions = array(
			'url' => $this->url().'missions/',
			'count' => Simm_Mission::Count_All(), 
			'title' => $language->get($this->module, array('admin','overview','missions'))
			);			
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('simm','admin','overview'));
		$template->title = $this->title;
		$template->characters = $this->characters;
		$template->positions = $this->positions;
		$template->departments = $this->departments;
		$template->simms = $this->simms;
		$template->fleets = $this->fleets;
		$template->missions = $this->missions;
		
		return $template;
	}
}