<?php

class Simm_Admin extends Admin {

	protected $parent;
	protected $mode;

	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('content'), array('view','edit','add','delete','list','admin'),'admin');
		$this->menu_title = Language::Retrieve()->get($this->module, array('admin','menu','title'));
		$this->menu_items = array(
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Characters')),
				  'url' => $this->url().'characters/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Departments')),
				  'url' => $this->url().'departments/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Fleets')),
				  'url' => $this->url().'fleets/'),			
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Missions')),
				  'url' => $this->url().'missions/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Positions')),
				  'url' => $this->url().'positions/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Ranks')),
				  'url' => $this->url().'ranks/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Simms')),
				  'url' => $this->url().'simms/'),
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Specifications')),
				  'url' => $this->url().'specifications/'),		
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Technology')),
				  'url' => $this->url().'technology/'),	
			array('title' => Language::Retrieve()->get($this->module, array('admin','menu','Uniforms')),
				  'url' => $this->url().'uniforms/'),					  
		);		
	}
/**	public function execute_list(){
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->content = Content::Get_All(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->content = Content::Get_All(20);
		}

		$count = Content::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
	} **/
	/**
	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->content = Content::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('content',$this->content->id(), 'admin'), $this->url('edit/' . $this->content->id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->content->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		$body->set_value($this->content->get_body());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	} **/

	public function execute($parent){
		$this->parent = $parent;
		$arg = $this->parent->resource()->get_argument();
		try {
			switch($arg) {
/**				case 'add':
					$this->parent->resource()->consume_argument();
					$this->execute_add();
					break;
				case 'edit':
					$this->parent->resource()->consume_argument();
					$this->execute_edit();
					return;
					break;
				case 'list':
				default:
					$this->parent->resource()->consume_argument();
					$this->execute_list();
					return;
					break; **/
			}
		} catch(Exception $e){

		}
	}

	public function display_menu($selected){
		$template = MCMS::Get_Instance()->output()->start(array('simm','admin','menu'));
		$template->title = $this->menu_title;
		$template->items = $this->menu_items;
		$template->url = $this->url;
		$template->selected = $selected;
		return $template;
	}
/**	public function display_list(){
		$template = MCMS::Get_Instance()->output()->start(array('content','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->content as $content){
			$template->content[] = array(
				'title' => $content->get_title(),
				'edit' => $this->url('edit/' . $content->id())
			);
		}
		return $template;
	}

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('content','admin','edit'));
		$template->title = $this->content->get_title();
		$template->form = $this->form->display();
		return $template;
	}
	public function display_add() {
		$template = MCMS::Get_Instance()->output()->start(array('content','admin','add'));
		$template->title = $this->title;
		$template->form = $this->form->display();
		return $template;
	} **/

	public function display(){
		switch($this->mode) {
			case 'add':
				return $this->display_add();
			case 'edit':
				return $this->display_edit();			
			case 'list':
				return $this->display_list();			
				break;
		}
	}

}
