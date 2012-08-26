<?php
class Group_Admin_List extends Group_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->mode = 'list';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->groups = Group::Get_All(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->groups = Group::Get_All(20);
		}

		$count = Group::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('group','admin','list'));
		$template->groups = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->groups as $group){
			$template->groups[] = array(
				'title' => $group->get_title(),
				'edit' => $this->url('edit/' . $group->id())
			);
		}
		return $template;
	}
}