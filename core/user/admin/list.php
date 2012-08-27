<?php
class User_Admin_List extends User_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$grouping_type = $this->parent->resource()->get_argument();
		switch($grouping_type) {
			case 'validated':
				//Todo: Validated Lookup
				$this->parent->resource()->consume_argument();
				$this->current_type = array('id' => 'validated');
				$pageNum = $this->parent->resource()->get_argument();
				if(is_numeric($pageNum) && ((int) $pageNum) > 0){
					$this->parent->resource()->consume_argument();
					$this->users = User::Get_All(20, ($pageNum - 1) * 20);
					$this->page = $pageNum;
				} else {
					$this->page = 1;
					$this->users = User::Get_All(20);
				}
				$this->count = User::Count_All();
				break;
			case 'all':
				$this->parent->resource()->consume_argument();
			default:
				$this->current_type = array('id' => 'all');
				$pageNum = $this->parent->resource()->get_argument();
				if(is_numeric($pageNum) && ((int) $pageNum) > 0){
					$this->parent->resource()->consume_argument();
					$this->users = User::Get_All(20, ($pageNum - 1) * 20);
					$this->page = $pageNum;
				} else {
					$this->page = 1;
					$this->users = User::Get_All(20);
				}
				$this->count = User::Count_All();
				break;
		}
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->add = $language->get($this->module, array('admin','list','add'));
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		$this->pages = array();
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
				'count' => User::Count_All()
			),
			array(
				'id' => 'validated',
				'url' => $this->url('list/validated/1'),
				'title' => $language->get($this->module, array('admin','list','grouping_type','validated')),
				'count' => User::Count_All()
			)
		);
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('user','admin','list'));
		$template->content = array();
		$template->add = $this->url('add/');
		$template->add_url = $this->add;
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->count = $this->count;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		$template->grouping_types = $this->grouping_types;
		$template->current_type = $this->current_type;
		foreach($this->users as $user){
			$template->users[] = array(
				'id' => $user->get_id(),
				'username' => $user->get('local_username'),
				'edit' => $this->url('edit/' . $user->get_id())
			);
		}

		return $template;
	}
}