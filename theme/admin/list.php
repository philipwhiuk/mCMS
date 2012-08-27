<?php
class Theme_Admin_List extends Theme_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->themes = Theme::Get_All(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->themes = Theme::Get_All(20);
		}
		$this->currentTheme = Theme::Get_By_ID(MCMS::Get_Instance()->site()->get('theme'));
		$count = Theme::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
		$this->install_title = $language->get($this->module, array('admin','install','title'));
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}
	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('theme','admin','list'));
		$template->themes = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->install_title = $this->install_title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;	
		
		foreach($this->themes as $theme){
			$tTheme = array();
			$tTheme['id'] = $theme->id();
			$tTheme['title'] = $theme->name();
			$tTheme['version'] = '';
			$tTheme['description'] = '';
			$tTheme['edit'] = $this->url('edit/' . $theme->id());
			$tTheme['author'] = '';
			$tTheme['image'] = 'http://philip.whiuk.com/wp-content/themes/graphene/screenshot.png';
			$tTheme['url'] = '';
			$tTheme['activate'] = $this->url('activate/' . $theme->id());
			$tTheme['preview'] = $this->url('preview/' . $theme->id());
			$tTheme['delete'] = $this->url('delete/' . $theme->id());
			if($theme->parent() != null) {
				$tTheme['parent'] = $theme->parent()->name();
			}
			else {
				$tTheme['parent'] = '';
			}
			$template->themes[] = $tTheme;
			if($tTheme['id'] == $this->currentTheme->id()) {
				$template->current = $tTheme;
			}
		}
		return $template;
	}
}