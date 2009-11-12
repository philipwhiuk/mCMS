<?php

class News_Page_Main_Article_View extends News_Page_Main {
	
	private $article;
	
	public function __construct($parent, $category, $article){
		parent::__construct($parent);
		$this->category = $category;
		$this->article = $article;
		$this->article->content();
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('news','page','article','view'));
		
		$language = Language::Retrieve();
		$module = Module::Get('news');
		
		$df = $language->get($module, array('category','list', 'date'));
		
		$template->title = $this->article->content()->get_title();
		$template->body = $this->article->content()->get_body();
		$template->time = date($df, $this->article->time());
		return $template;
	}
}