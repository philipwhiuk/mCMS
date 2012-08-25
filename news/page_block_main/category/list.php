<?php

class News_Page_Main_Category_List extends News_Page_Main {
	
	private $category;
	private $categories = array();
	private $articles = array();
	
	public function __construct($parent, $category){
		parent::__construct($parent);
		if($category instanceof News_Category){
			Permission::Check(array('news/category',$category->id()), array('view','edit','add','delete','list'),'list');
			$category->content();
			$this->category = $category;
			$this->categories = $category->children();
			$this->articles = $category->articles();
		} else {
			Permission::Check(array('news/category',$category), array('view','edit','add','delete','list'),'list');
			$this->categories = News_Category::Get_By_Parent($category);
			$this->articles = News_Article::Get_By_Category($category);
		}
		foreach($this->categories as $child){
			$child->content();
		}
		foreach($this->articles as $article){
			$article->content();
		}
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('news','page','category','list'));
		
		$language = Language::Retrieve();
		
		$system = MCMS::Get_Instance();
		
		$module = Module::Get('news');
		
		if($this->category instanceof News_Category){
			$template->category = array(
				'title'	=> $this->category->content()->get_title(),
				'body'	=> $this->category->content()->get_body()
			);
			$url = join('/', $this->category->parents()) . '/';
		} else {
			$template->category = array(
				'title'	=> $language->get($module, array('category','list','title')),
				'body'	=> $language->get($module, array('category','list','body'))
			);
			$url = '';
		}
		
		foreach($this->categories as $category){
			$template->categories[] = array(
				'title' => $category->content()->get_title(),
				'body' => $category->content()->get_body(),
				'url' => $system->url(Resource::Get_By_Argument($module, $url .= $category->id())->url())
			);
		}
		
		$df = $language->get($module, array('category','list', 'date'));
		
		foreach($this->articles as $article){
			$template->articles[] = array(
				'title' => $article->content()->get_title(),
				'body' => $article->content()->get_body(),
				'time' => date($df, $article->time()),
				'url' => $system->url(Resource::Get_By_Argument($module, $url .= 'article/' . $article->id())->url())
			);
		}
		
		/*
		$template->title = $language->get($module, array('list','title'));
		
		foreach($this->content as $content){
			$template->content[] = array(
				'name' => $content->get_title(),
				'url' => $system->url(Resource::Get_By_Argument($module, $content->id())->url())
			);
		}*/
		
		
		return $template;
	}
	
}