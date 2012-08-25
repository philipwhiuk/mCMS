<?php

abstract class Content_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Content_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/edit');				
					return new Content_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');			
					return new Content_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');	
			return new Content_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('content'), array('view','edit','add','delete','list','admin'),'admin');		
	}
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
	}	
	public function execute_list(){
		$grouping_type = $this->parent->resource()->get_argument();
		switch($grouping_type) {
			case 'publish':
				$this->parent->resource()->consume_argument();
				$this->current_type = array('id' => 'publish');
				
				$pageNum = $this->parent->resource()->get_argument();
				if(is_numeric($pageNum) && ((int) $pageNum) > 0){
					$this->parent->resource()->consume_argument();
					$this->content = Content::Get_Published(20, ($pageNum - 1) * 20);
					$this->page = $pageNum;
				} else {
					$this->page = 1;
					$this->content = Content::Get_Published(20);
				}
				$count = Content::Count_All();
				break;
			case 'all':
			default:
				$this->current_type = array('id' => 'all');
				$pageNum = $this->parent->resource()->get_argument();
				if(is_numeric($pageNum) && ((int) $pageNum) > 0){
					$pageNum = (int) $pageNum;
					$this->content = Content::Get_All(20, ($pageNum - 1) * 20);
					$this->parent->resource()->consume_argument();
					$this->page = $pageNum;
				} else {
					$this->page = 1;
					$this->content = Content::Get_All(20);
				}
				$count = Content::Count_Published();
				break;
				
		};
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
		$this->search = $language->get($this->module, array('admin','list','search'));
		$this->grouping_types = 
		array(
			array(
				'id' => 'all',
				'url' => $this->url('list/all/1'),
				'title' => $language->get($this->module, array('admin','list','grouping_type','all')),
				'count' => Content::Count_All()
			),
			array(
				'id' => 'publish',
				'url' => $this->url('list/publish/1'),
				'title' => $language->get($this->module, array('admin','list','grouping_type','publish')),
				'count' => Content::Count_Published()
			)
		);
		$this->mode = 'list'; 
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
