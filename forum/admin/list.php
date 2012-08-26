<?php
class Forum_Admin_List extends Forum_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
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
	public function display(){
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
}