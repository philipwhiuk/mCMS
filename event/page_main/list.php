<?php
class Event_Page_Main_List extends Event_Page_Main {
	public function __construct($parent){
		parent::__construct($parent);
		$this->events = Event::Get_All();
		Permission::Check(array('event'), array('view','edit','add','delete','list'),'list');
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('event','page','list'));
		
		$language = Language::Retrieve();
		
		$system = MCMS::Get_Instance();
		
		$module = Module::Get('event');
		
		$template->title = $language->get($module, array('list','title'));
		
		foreach($this->events as $event){
			$template->events[] = array(
				'name' => $event->get_content()->get_title(),
				'url' => $system->url(Resource::Get_By_Argument($module, $event->get_id())->url())
			);
		}
		
		
		return $template;
	}
}