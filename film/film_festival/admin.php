<?php

abstract class Film_Festival_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $pages;
	private $film_festivals = array();
	
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Film_Festival_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/edit');					
					return new Film_Festival_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Film_Festival_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Film_Festival_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('film_festival'), array('view','edit','add','delete','list','admin'),'admin');

	}
	public static function film_festival_sort($a,$b) {
		if(
			strtolower($a->get_content()->get_title()) 
			== 
			strtolower($b->get_content()->get_title())
		) {
			return 0;
		}
		else {
			return (
				strtolower($a->get_content()->get_title()) 
				< 
				strtolower($b->get_content()->get_title())
			) ? -1 : 1;
		}
	}
	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->film_festival = Film_Festival::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('film_festival',$this->film_festival->get_id(), 'admin'), $this->url('edit/' . $this->film_festival->get_id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->film_festival->get_content()->get_title());
		
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		$body->set_value($this->film_festival->get_content()->get_body());
		
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
	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('film','admin','edit'));
		$template->title = $this->film_festival->get_content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
}
