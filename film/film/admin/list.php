<?php
class Film_Admin_List extends Film_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->film = array();
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$films = Film::Get_All();
		@usort($films,array("Film_Admin","film_sort"));
		if(!(($page-1)*20 <= count($films))) {
			$page = (int) (count($films)/20)-1;
		}
		for($i = ($page-1)*20; $i < $page*20 && $i < count($films); $i++) {
			if($films[$i] instanceof Film) { $this->film[] = $films[$i]; }
		}
		$this->page = $page;
		$count = Film::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->page_title = $language->get($this->module, array('admin','list','title'));
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('film','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->page_title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->film as $film){
			$filmT = array();
			try {
				$filmT['title'] = $film->get_description()->get_title();
			} catch (Content_Not_Found_Exception $e) {
				$filmT['title'] = '';
			}
			$filmT['edit'] = $this->url('edit/' . $film->get_id());
			$template->films[] = $filmT;
		}
		return $template;
	}
}