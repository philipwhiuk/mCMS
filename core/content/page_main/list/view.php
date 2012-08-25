<?php
class Content_Page_Main_List_View extends Content_Page_Main {

	public function __construct($parent, $page){
		parent::__construct($parent);
		$this->page = $page;
		$this->content = Content::Get_All(20, ($page - 1) * 20);
		$count = Content::Count_All();
		$this->module = Module::Get('content');
		$system = MCMS::Get_Instance();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $parent->url(trim($this->module->id() . '/list/' . $pg));
		}
		$this->check_noID('view');		
	}
	public function display() {
		$system = MCMS::Get_Instance();
		$template = MCMS::Get_Instance()->output()->start(array('content','page','list','view'));
		$template->modes = $this->modes;
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;

		$template->page_count = $this->page_count;
		$template->page = $this->page;		
		
		foreach($this->content as $content){
			$template->content[] = array(
				'title' => $content->get_title(),
				'view_url' => $system->url(Resource::Get_By_Argument($this->module, '/entry/'.$content->id().'/view')->url())
			);
		}		
		return $template;
	}
}