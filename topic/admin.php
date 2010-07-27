<?php
class Topic_Admin extends Admin {
	protected $mode;
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		$this->name = Language::Retrieve()->get($this->module, array('admin','menu','name'));
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
	public function display_list(){
		$template = System::Get_Instance()->output()->start(array('topic','admin','list'));
		$template->topic = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->topic as $topic){
			$template->topic[] = array(
				'title' => $topic->content()->get_title(),
				'edit' => $this->url('edit/' . $topic->id())
			);
		}
		return $template;
	}
	public function display_menu() {
		$template = System::Get_Instance()->output()->start(array('topic','admin','menu'));
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
	public function execute_list() {
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$topics = Topic::Get_All();
		if(!(($page-1)*20 <= count($topics))) {
			$page = (int) (count($topics)/20)-1;
		}
		$this->topic = array();
		for($i = ($page-1)*20; $i < $page*20 && $i < count($topics); $i++) {
			if($topics[$i] instanceof Topic) { $this->topic[] = $topics[$i]; }
		}
		$this->page = $page;
		$count = Topic::Count_All();
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