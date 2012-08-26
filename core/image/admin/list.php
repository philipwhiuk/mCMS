<?php
class Image_Admin_List extends Image_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->images = Image::Get_All(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->images = Image::Get_All(20);
		}

		$count = Image::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
	}

	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('image','admin','list'));
		$template->images = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->images as $image){
			try {
				$imageT['title'] = $image->description()->get_title();
				$imageT['ContentNotFound'] = false;
			} catch (Content_Not_Found_Exception $e) {
				$imageT['title'] = '';
				$imageT['ContentNotFound'] = true;
			}
			$imageT['edit'] = $this->url('edit/' . $image->id());
			$template->images[] = $imageT;
		}
		return $template;
	}
}