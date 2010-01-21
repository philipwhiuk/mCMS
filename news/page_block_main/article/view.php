<?php

class News_Page_Block_Main_Article_View extends News_Page_Block_Main {
	
	private $article;
	
	public function __construct($parent, $category, $article){
		parent::__construct($parent);
		Permission::Check(array('news/article',$category->id()), array('view','edit','add','delete'),'view');
		$this->category = $category;
		$this->article = $article;
		$this->article->content();
	}
	
	public function display(){
		$system = System::Get_Instance();
		$template = $system->output()->start(array('news','page','block','article','view'));
		
		$language = Language::Retrieve();
		$module = Module::Get('news');
		
		$df = $language->get($module, array('category','list', 'date'));
		
		$url = join('/', $this->category->parents()) . '/article/' . $this->article->id();

		$template->title = $this->article->content()->get_title();
		$template->body = $this->article->content()->get_body();
		$template->time = date($df, $this->article->time());
		$template->url = $system->url(Resource::Get_By_Argument($module, $url)->url());
		return $template;
	}
}
