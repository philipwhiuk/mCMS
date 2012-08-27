<?php
class Link_Admin_List extends Link_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$grouping_type = $this->parent->resource()->get_argument();
		switch($grouping_type) {
			case 'publish':
				$this->parent->resource()->consume_argument();
				$this->current_type = array('id' => 'publish');
				
				$pageNum = $this->parent->resource()->get_argument();
				if(is_numeric($pageNum) && ((int) $pageNum) > 0){
					$this->parent->resource()->consume_argument();
					$this->links = Link::Get_Published(20, ($pageNum - 1) * 20);
					$this->page = $pageNum;
				} else {
					$this->page = 1;
					$this->links = Link::Get_Published(20);
				}
				$count = Link::Count_Published();
				break;
			case 'all':
				$this->parent->resource()->consume_argument();
			default:
				$this->current_type = array('id' => 'all');
				$pageNum = $this->parent->resource()->get_argument();
				if(is_numeric($pageNum) && ((int) $pageNum) > 0){
					$pageNum = (int) $pageNum;
					$this->links = Link::Get_All(20, ($pageNum - 1) * 20);
					$this->parent->resource()->consume_argument();
					$this->page = $pageNum;
				} else {
					$this->page = 1;
					$this->links = Link::Get_All(20);
				}
				$count = Link::Count_All();
				break;
				
		};
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
		$this->search = $language->get($this->module, array('admin','list','search'));
		$this->grouping_types = 
		array(
			array(
				'id' => 'all',
				'url' => $this->url('list/all/1'),
				'title' => $language->get($this->module, array('admin','list','grouping_type','all')),
				'count' => Link::Count_All()
			),
			array(
				'id' => 'publish',
				'url' => $this->url('list/publish/1'),
				'title' => $language->get($this->module, array('admin','list','grouping_type','publish')),
				'count' => Link::Count_Published()
			)
		);
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('link','admin','list'));
		$template->links = array();
		$template->edit = $this->edit;
		$template->search = $this->search;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		$template->grouping_types = $this->grouping_types;
		$template->current_type = $this->current_type;
		foreach($this->links as $link){
			$template->links[] = array(
				'title' => $link->get_title(),
				'edit' => $this->url('edit/' . $link->id())
			);
		}
		return $template;
	}
}