<?php
class Event_Admin_List extends Event_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$events = Event::Get_All();
		usort($events,array("Event_Admin","event_sort"));
		if(!(($page-1)*20 <= count($events))) {
			$page = (int) round((count($events)/20), 0, PHP_ROUND_HALF_UP)+1;
		}
		$this->event = array();
		for($i = ($page-1)*20; $i < $page*20; $i++) {
			if(isset($events[$i]) && $events[$i] instanceof Event) { $this->event[] = $events[$i]; }
		}
		$this->page = $page;
		$count = Event::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->page_title = $language->get($this->module, array('admin','list','title'));
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('event','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->page_title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->events as $event){
			$template->events[] = array(
				'title' => $event->get_content()->get_title(),
				'edit' => $this->url('edit/' . $event->get_id())
			);
		}
		return $template;
	}
}