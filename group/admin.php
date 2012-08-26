<?php

abstract class Group_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Group_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/add');					
					return new Group_Admin_Add($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Group_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Group_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('group'), array('view','edit','add','delete','list','admin'),'admin');
	
	}
	/**
	public function execute_add() {
		$this->mode = 'add';  
		$language = Language::Retrieve();
		$this->title = $language->get($this->module, array('admin','add','page_title'));
		$this->form = new Form(array('content','add', 'admin'), $this->url('add/'));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','add','title')));
		$title->set_value('');
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','add','body')));
		$body->set_value('');
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','add','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->content->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}		
	}	**/

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

	}
	**/
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
	}
}
