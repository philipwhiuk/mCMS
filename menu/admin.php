<?php

abstract class Menu_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $menus;
	private $pages;
	
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Menu_Admin_Menu($panel,$parent);
	}
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/add');					
					return new Menu_Admin_Add($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Menu_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Menu_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('menu'), array('view','edit','add','delete','list','admin'),'admin');

	}
	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->menu = Menu::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('content',$this->menu->id(), 'admin'), $this->url('edit/' . $this->content->id()));
		
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
			
			$this->menu->update($data);
			
			System::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	}

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('menu','admin','edit'));
		$template->title = $this->content->get_title();
		$template->form = $this->form->display();
		return $template;
	}
}
