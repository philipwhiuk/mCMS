<?php

class Event_Admin extends Admin {

	protected $parent;
	protected $mode;
	private $pages;
	private $events = array();
	
	public static function Load_Menu($panel, $parent) {
		$parent->resource()->get_module()->file('admin/menu');
		return new Event_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('admin/edit');					
					return new Event_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$parent->resource()->get_module()->file('admin/list');				
					return new Event_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$parent->resource()->get_module()->file('admin/list');		
			return new Event_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('event'), array('view','edit','add','delete','list','admin'),'admin');
		$this->title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
		$this->menu_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Add')),
				  'url' => $this->url().'add/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Manage')),
				  'url' => $this->url().'list/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Permissions')),
				  'url' => $this->url().'permissions/'),			  
		);			
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

	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->event = Event::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('event',$this->event->get_id(), 'admin'), $this->url('edit/' . $this->event->get_id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->event->get_content()->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		$body->set_value($this->event->get_content()->get_body());
		
		$starttime = Form_Field::Create('starttime', array('textbox'));
		$starttime->set_label($language->get($this->module, array('admin','edit','starttime')));
		$starttime->set_value($this->event->get_starttime());
		
		$finishtime = Form_Field::Create('finishtime', array('textbox'));
		$finishtime->set_label($language->get($this->module, array('admin','edit','finishtime')));
		$finishtime->set_value($this->event->get_finishtime());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$body,$starttime,$finishtime, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->event->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
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
			var_dump($e);
		}
		$this->execute_list();
	}

	public function display_menu($selected){
		$template = MCMS::Get_Instance()->output()->start(array('event','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->title;
		$template->selected = $selected;
		$template->items = $this->menu_items;
		return $template;
	}

	public function display_list(){
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

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('event','admin','edit'));
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
