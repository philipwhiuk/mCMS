<?php

class Event_Page_Main_View extends Event_Page_Main {
	
	private $event;
	
	public function __construct($parent, $event){
		parent::__construct($parent);
		Module::Get('event')->file('event_impl/page_main/view');
		Permission::Check(array('event',$event->get_id()), array('view','edit','add','delete','list'),'view');
		$this->event = $event;
		$this->objects = $event->get_objects();
		$this->implViews = array();
		$class = $event->get_module()->load_section('Event_Impl_Page_Main_View');
		foreach($this->objects as $object) {			
			$this->implViews[] = new $class($object);
		}
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('event','page','view'));
		$template->title = $this->event->get_content()->get_title();
		$template->description = $this->event->get_content()->get_body();
		$template->objects = array();
		foreach($this->implViews as $implView) {
			$template->objects[] = $implView->display();
		}
		return $template;	
	}
}