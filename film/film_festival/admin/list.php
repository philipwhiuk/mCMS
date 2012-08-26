<?php
class Film_Festival_Admin_List extends Film_Festival_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$film_festivals = Film_Festival::Get_All();
		usort($film_festivals,array("Film_Festival_Admin","film_festival_sort"));
		if(!(($page-1)*20 <= count($film_festivals))) {
			$page = (int) (count($film_festivals)/20)-1;
		}
		for($i = ($page-1)*20; ($i < $page*20 && $i < count($film_festivals)) ; $i++) {
			if($film_festivals[$i] instanceof Film_Festival) { $this->film_festivals[] = $film_festivals[$i]; }
		}
		$this->page = $page;
		$count = Film_Festival::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('film_festival','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->film_festivals as $film_festival){
			$template->film_festivals[] = array(
				'title' => $film_festival->get_content()->get_title(),
				'edit' => $this->url('edit/' . $film_festival->get_id())
			);
		}
		return $template;
	}
}