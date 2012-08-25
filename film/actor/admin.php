<?php

class Actor_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $pages;
	private $actor;
	private $actors = array();

	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Actor_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/edit');					
					return new Actor_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Actor_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Actor_Admin_List($panel,$parent);		
		}
	}
	
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('actor'), array('view','edit','add','delete','list','admin'),'admin');
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
	public static function actor_sort($a,$b) {
		if(
		   strtolower(
					  $a->get_description()->get_title()
			) == strtolower($b->get_description()->get_title())) {
			return 0;
		}
		else {
			return (strtolower($a->get_description()->get_title()) < strtolower($b->get_description()->get_title())) ? -1 : 1;
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
		$actors = Actor::Get_All();
		usort($actors,array("Actor_Admin","actor_sort"));
		if(!(($page)*20 < count($actors)) && $page > 1) {
			$page = (int) round(count($actors)/20);
		}
		for($i = ($page-1)*20; ($i < $page*20 && $i < count($actors)); $i++) {
			if($actors[$i] instanceof Actor) { $this->actor[] = $actors[$i]; }
		}
		$this->page = $page;
		$count = Actor::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->page_title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}		
	}

	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->actor = Actor::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('actor',$this->actor->id(), 'admin'), $this->url('edit/' . $this->actor->id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->actor->get_description()->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		$body->set_value($this->actor->get_description()->get_body());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	}

	public function execute($parent){
		$this->parent = $parent;

	}

	public function display_menu($selected){
		$template = MCMS::Get_Instance()->output()->start(array('actor','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->title;
		$template->selected = $selected;
		$template->items = $this->menu_items;
		return $template;
	}

	public function display_list(){
		$template = MCMS::Get_Instance()->output()->start(array('actor','admin','list'));
		$template->actor = array();
		$template->edit = $this->edit;
		$template->title = $this->page_title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->actors as $actor){
			$template->actors[] = array(
				'title' => $actor->get_description()->get_title(),
				'edit' => $this->url('edit/' . $actor->get_id())
			);
		}
		return $template;
	}

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('actor','admin','edit'));
		$template->title = $this->actor->get_description()->get_title();
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
