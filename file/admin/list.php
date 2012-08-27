<?php
class File_Admin_List extends File_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
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

	public function display(){
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
}