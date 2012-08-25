<?php
	class Event_Page_Block_Main_Next extends Event_Page_Block_Main {
		function __construct($parent, $event) {
			Permission::Check(array('event',$event->get_id()), array('view','edit','add','delete','list'),'view');
			$this->event = $event;
			Module::Get('event')->file('event_impl/page_block_main/next');
			$this->objects = $event->get_objects();
			$this->implViews = array();
			$class = $event->get_module()->load_section('Event_Impl_Page_Block_Main_Next');
			foreach($this->objects as $object) {			
				$this->implViews[] = new $class($object);
			}
		}
		function display() {
			$template = MCMS::Get_Instance()->output()->start(array('event','page','block','next'));
			$language = Language::Retrieve();
			$module = Module::Get('event');
			$template->title = $language->get($module, array('next','title'));
			$template->objects = array();
			foreach($this->implViews as $implView) {
				$template->objects[] = $implView->display();
			}
			return $template;
		}
	}