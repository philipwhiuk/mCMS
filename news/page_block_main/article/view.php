<?php

class News_Page_Block_Main_Article_View extends News_Page_Block_Main {
	
	private $article;
	
	public function __construct($parent, $category, $article){
		parent::__construct($parent);
		Permission::Check(array('news/article',$category->id()), array('view','edit','add','delete'),'view');
		$this->category = $category;
		$this->article = $article;
		$this->article->brief();
		$this->article->content();
	}
	
	public function display(){
		$system = System::Get_Instance();
		$template = $system->output()->start(array('news','page','block','article','view'));
		
		$language = Language::Retrieve();
		$module = Module::Get('news');
		
		$df = $language->get($module, array('category','list', 'date'));
		
		$furl = join('/', $this->category->parents()) . '/article/' . $this->article->id();
		$surl = join('/', $this->category->parents()) . '/list/article/' . $this->article->id();

		$template->b_title = $this->article->brief()->get_title();
		$template->b_body = $this->article->brief()->get_body();

		$template->c_title = $this->article->content()->get_title();
		$template->c_body = $this->article->content()->get_body();
		$template->time = date($df, $this->article->time());
		$template->furl = $system->url(Resource::Get_By_Argument($module, $furl)->url());
		$template->surl = $system->url(Resource::Get_By_Argument($module, $surl)->url());
		return $template;
	}
}
