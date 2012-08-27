<?php
class Actor_Admin_List extends Actor_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$actors = Actor::Get_All();
		usort($actors,array("Actor_Admin","actor_sort"));
		if(!(($page)*20 < count($actors)) && $page > 1) {
			$page = (int) round(count($actors)/20);
		}
		for($i = ($page-1)*20; ($i < $page*20 && $i < count($actors)); $i++) {
			if($actors[$i] instanceof Actor) { $this->actor[] = $actors[$i]; }
		}
		$this->page = $page;
		$count = Actor::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->page_title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}	
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('actor','admin','list'));
		$template->actor = array();
		$template->edit = $this->edit;
		$template->title = $this->page_title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->actors as $actor){
			$template->actors[] = array(
				'title' => $actor->get_description()->get_title(),
				'edit' => $this->url('edit/' . $actor->get_id())
			);
		}
		return $template;
	}

}