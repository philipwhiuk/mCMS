<?php
class Admin_Dashboard_Resources extends Admin_Dashboard {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->resources = Resource::Get_Selection(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->resources = Resource::Get_Selection(20);
		}

		$count = Resource::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('dashboard','resources','edit'));
		$this->title = $language->get($this->module, array('dashboard','resources','title'));
		$this->resourcePath = $language->get($this->module, array('dashboard','resources','resourcePath'));

		
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('resources/' . $pg);
		}
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','resources'));
		$template->edit = $this->edit;
		$template->resourcePath = $this->resourcePath;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->resources as $resource){
			$rT = array();
			$rT['path'] = $resource->get_path();
			$rT['edit'] = $this->url('edit/' . $resource->get_id());		
			$template->resources[] = $rT;
		}
		return $template;
	}
}