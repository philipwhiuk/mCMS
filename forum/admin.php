<?php
abstract class Forum_Admin extends Admin {
	protected $mode;

	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Forum_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/edit');					
					return new Forum_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Forum_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Forum_Admin_List($panel,$parent);		
		}
	}
	
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('forum'), array('view','edit','add','delete','list','admin'),'admin');

	}
	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('news','admin','edit'));
		$template->title = $this->forum->content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->forum = Forum::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();
		$language = Language::Retrieve();
		$this->form = new Form(array('news',$this->forum->id(), 'admin'), $this->url('edit/' . $this->forum->id()));

		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->forum->content()->get_title());
		
		$description = Form_Field::Create('description', array('richtext','textarea'));
		$description->set_label($language->get($this->module, array('admin','edit','description')));
		$description->set_value($this->forum->content()->get_body());

		$language_field = Form_Field::Create('language_field', array('select'));
		$language_field->set_label($language->get($this->module, array('admin','edit','language_field')));
		$langs = Language::Get_All();
		try {
			$current_lang = $this->forum->language()->id();
		}
		catch (Language_Not_Found_Exception $lnfe) {
			$current_lang = 0;
		}
		if($current_lang == 0) {
			$language_field->set_option(0,$language->get($this->module, array('admin','edit','no_lang')),true);
		}
		else {
			$language_field->set_option(0,$language->get($this->module, array('admin','edit','no_lang')),false);
		}
		foreach ($langs as $lang) {
			if($lang->id() == $current_lang) {
				$language_field->set_option($lang->id(),$lang->name(),true);
			}
			else {
				$language_field->set_option($lang->id(),$lang->name(),false);
			}
		}
		
		$parent = Form_Field::Create('parent', array('select'));
		$parent->set_label($language->get($this->module, array('admin','edit','parent')));
		$ps = Forum::Get_All();
		try {
			$current_p = $this->forum->parent()->id();
		}
		catch (Forum_Not_Found_Exception $fnfe) {
			$current_p = 0;
		}
		if($current_p == 0) {
			$parent->set_option(0,$language->get($this->module, array('admin','edit','no_parent')),true);
		}
		else {
			$parent->set_option(0,$language->get($this->module, array('admin','edit','no_parent')),false);
		}
		foreach ($ps as $p) {
			if($p->id() == $current_p) {
				$parent->set_option($p->id(),$p->content()->get_title(),true);
			}
			else {
				$parent->set_option($p->id(),$p->content()->get_title(),false);
			}
		}
		
		$depth = Form_Field::Create('depth', array('textbox'));
		$depth->set_label($language->get($this->module, array('admin','edit','depth')));
		$depth->set_value($this->forum->depth());
		
		//Should be checkbox
		$has_topics = Form_Field::Create('has_topics', array('textbox'));
		$has_topics->set_label($language->get($this->module, array('admin','edit','has_topics')));
		$has_topics->set_value($this->forum->has_topics());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));

		$this->form->fields($title,$description,$language_field,$parent,$depth,$has_topics,$submit);
	}

}