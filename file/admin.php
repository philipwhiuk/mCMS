<?php

class File_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $pages;
	
	public static function Load_Menu($panel, $parent) {
		$parent->resource()->get_module()->file('admin/menu');
		return new File_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('admin/edit');					
					return new File_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$parent->resource()->get_module()->file('admin/list');				
					return new File_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$parent->resource()->get_module()->file('admin/list');		
			return new File_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('content'), array('view','edit','add','delete','list','admin'),'admin');
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

	public function execute_list(){
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->files = File::Get_All(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->files = File::Get_All(20);
		}

		$count = File::Count_All();
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
		$this->file = File::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		$language = Language::Retrieve();
		
		$this->form = new Form(array('file',$this->file->id(), 'admin'), $this->url('edit/' . $this->file->id()));
		
		$name = Form_Field::Create('name', array('textbox'));
		$name->set_label($language->get($this->module, array('admin','edit','name')));
		$name->set_value($this->file->name());

		$mime = Form_Field::Create('mime', array('textbox'));
		$mime->set_label($language->get($this->module, array('admin','edit','mime')));
		$mime->set_value($this->file->mime());

		$size = Form_Field::Create('size', array('textbox'));
		$size->set_label($language->get($this->module, array('admin','edit','size')));
		$size->set_value($this->file->size());

		$time = Form_Field::Create('time', array('textbox'));
		$time->set_label($language->get($this->module, array('admin','edit','time')));
		$time->set_value($this->file->time());

		$path = Form_Field::Create('path', array('textbox'));
		$path->set_label($language->get($this->module, array('admin','edit','path')));
		$path->set_value($this->file->path());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($name,$mime,$size,$path,$submit);
		
		try {
			$data = $this->form->execute();
			
			$this->file->update($data);
			
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
		$template = MCMS::Get_Instance()->output()->start(array('file','admin','menu'));
		$template->url = $this->url;
		$template->title = $this->title;
		$template->items = $this->menu_items;
		return $template;
	}

	public function display_list(){
		$template = MCMS::Get_Instance()->output()->start(array('file','admin','list'));
		$template->files = array();
		$template->edit = $this->edit;
		$template->title = $this->page_title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->files as $file){
			$template->files[] = array(
				'name' => $file->name(),
				'edit' => $this->url('edit/' . $file->id())
			);
		}
		return $template;
	}

	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('file','admin','edit'));
		$template->title = $this->file->name();
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
