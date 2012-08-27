<?php

class Gallery_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $galleries;
	private $pages;

	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Gallery_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/add');					
					return new Gallery_Admin_Add($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Gallery_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Gallery_Admin_List($panel,$parent);		
		}
	}
	
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('gallery'), array('view','edit','add','delete','list','admin'),'admin');

	}

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

	public function display_menu($selected){
		$template = MCMS::Get_Instance()->output()->start(array('gallery','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->menu_title;
		$template->items = $this->menu_items;	
		$template->selected = $selected;
		return $template;
	}



	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('gallery','admin','edit'));
		$template->title = $this->content->get_title();
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
