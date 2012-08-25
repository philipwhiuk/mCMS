<?php
class Forum_Admin extends Admin {
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
		Permission::Check(array('film_festival'), array('view','edit','add','delete','list','admin'),'admin');

	}
	public function display() {
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'categories'){
			return $this->display_categories();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		} 
	}
	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('news','admin','edit'));
		$template->title = $this->forum->content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
	public function display_list(){
		$template = MCMS::Get_Instance()->output()->start(array('forum','admin','list'));
		$template->forum = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->forum as $forum){
			$template->forum[] = array(
				'title' => $forum->content()->get_title(),
				'edit' => $this->url('edit/' . $forum->id())
			);
		}
		return $template;
	}

	public function execute($parent){
		$this->parent = $parent;
		$arg = $this->parent->resource()->get_argument();
		try {
			if($arg == 'list'){
				$this->parent->resource()->consume_argument();
				$this->execute_list();
				return;
			} elseif($arg == 'posts') {
				$this->parent->resource()->consume_argument();
				$this->execute_categories();
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
	public function execute_list() {
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$forums = Forum::Get_All();
		if(!(($page-1)*20 <= count($forums))) {
			$page = (int) (count($forums)/20)-1;
		}
		$this->forum = array();
		for($i = ($page-1)*20; $i < $page*20 && $i < count($forums); $i++) {
			if($forums[$i] instanceof Forum) { $this->forum[] = $forums[$i]; }
		}
		$this->page = $page;
		$count = Forum::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$this->pages = array();
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}
}