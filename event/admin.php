<?php

class Event_Admin extends Admin {

	protected $parent;
	protected $mode;

	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('event'), array('view','edit','add','delete','list','admin'),'admin');
		$this->name = Language::Retrieve()->get($this->module, array('admin','menu','name'));
	}
	public static function event_sort($a,$b) {
		if(
		   strtolower(
					  $a->get_content()->get_title()
			) == strtolower($b->get_content()->get_title())) {
			return 0;
		}
		else {
			return (strtolower($a->get_content()->get_title()) < strtolower($b->get_content()->get_title())) ? -1 : 1;
		}
	}
	public function execute_list(){
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
		$this->title = $language->get($this->module, array('admin','list','title'));
	}

	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->content = Event::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('event',$this->event->id(), 'admin'), $this->url('edit/' . $this->content->id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->event->get_content()->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		$body->set_value($this->event->get_content()->get_body());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->event->update($data);
			
			System::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	}

	public function execute($parent){
		$this->parent = $parent;
		$arg = $this->parent->resource()->get_argument();
		try {
			if($arg == 'list'){
				$this->parent->resource()->consume_argument();
				$this->execute_list();
				return;
			} elseif($arg == 'edit'){
				$this->parent->resource()->consume_argument();
				$this->execute_edit();
				return;
			}
		} catch(Exception $e){

		}
		$this->execute_list();
	}

	public function display_menu(){
		$template = System::Get_Instance()->output()->start(array('event','admin','menu'));
		$template->url = $this->url;
		$template->name = $this->name;
		return $template;
	}

	public function display_list(){
		$template = System::Get_Instance()->output()->start(array('event','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->event as $event){
			$template->event[] = array(
				'title' => $event->get_content()->get_title(),
				'edit' => $this->url('edit/' . $event->get_id())
			);
		}
		return $template;
	}

	public function display_edit(){
		$template = System::Get_Instance()->output()->start(array('event','admin','edit'));
		$template->title = $this->event->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}


	public function display(){
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		} 
	}

}
