<?php
class User_Admin extends Admin {
	public function __construct($a,$b){
		try {
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('user'), array('view','edit','add','delete','list','admin'),'admin');
		$this->name = Language::Retrieve()->get($this->module, array('admin','menu','name'));
		}
		catch(Exception $e) {
			var_dump($e);	
		}
	}
	public function display() {
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		}
	}
	public function display_list(){
		$template = System::Get_Instance()->output()->start(array('user','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->user as $user){
			$template->user[] = array(
				'title' => $user->get_id(),
				'edit' => $this->url('edit/' . $user->get_id())
			);
		}
		return $template;
	}
	public function display_menu() {
		$template = System::Get_Instance()->output()->start(array('user','admin','menu'));
		$template->url = $this->url;
		$template->name = $this->name;
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
			} elseif($arg == 'edit'){
				$this->parent->resource()->consume_argument();
				$this->execute_edit();
				return;
			}
		} catch(Exception $e){

		}
		$this->execute_list();
	}
	public function execute_list(){
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->user = User::Get_All(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->user = User::Get_All(20);
		}

		$count = User::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
	}
}