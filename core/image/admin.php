<?php

abstract class Image_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $pages;
	private $images;
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Image_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/add');					
					return new Image_Admin_Add($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Image_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Image_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('image'), array('view','edit','add','delete','list','admin'),'admin');
	}

	public function execute_edit(){
		$this->mode = 'edit';
		$language = Language::Retrieve();	

		$arg = $this->parent->resource()->get_argument();
		$this->image = Image::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();
		
		try {
			$this->title = $this->image->description()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$this->title = '';
		}
		
		$this->form = new Form(array('image',$this->image->id(), 'admin'), $this->url('edit/' . $this->image->id()));
		
		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$body = Form_Field::Create('body', array('richtext','textarea'));
		$body->set_label($language->get($this->module, array('admin','edit','body')));
		
		try {
			$description = $this->image->description();
			$title->set_value($description->get_title());
			$body->set_value($description->get_body());			
		} catch (Content_Not_Found_Exception $e) {
			$title->set_value('');
			$body->set_value('');
		}

		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$body, $submit);
		
		try {
			$data = $this->form->execute();
			
			$this->image->update($data);
			
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}

	}

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('image','admin','edit'));
		$template->title = $this->title;
		$template->form = $this->form->display();
		return $template;
	}
}
