<?php

class News_Feed_Main extends Feed_Main {

	private $category;
	private $articles;

	public function __construct($parent, $category){
		parent::__construct($parent);
		
		if($category instanceof News_Category){
			Permission::Check(array('news/category',$category->id()), array('view','edit','add','delete','list'),'list');
			$this->category = $category;
			$this->category->content();
			$this->articles = $category->articles(5);
		} else {
			Permission::Check(array('news/category',$category), array('view','edit','add','delete','list'),'list');
			$this->category = $category;
			$this->articles = News_Article::Get_By_Category($category, 6);
		}
		foreach($this->articles as $article){
			$article->brief();
		}
	}

	public static function Load($parent){
		
		// 1/2/3/4 - category

		$arg = $parent->resource()->get_argument();
		$categories = array();
		$category = 0;
		
		while(is_numeric($arg)){
			$category = News_Category::Get_By_ID_Parent((int) $arg, $category);
			$categories[] = $category;
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();	
		}
	
		return new News_Feed_Main($parent, $category);	

	}

	public function display(){
		$system = System::Get_Instance();
		$module = Module::Get('news');
		$template = $system->output()->start(array('news','feed'));
		$url = join('/', $this->category->parents()) . '/';
		if($this->category instanceof News_Category){
			$template->category = array(
				'title' => $this->category->content()->get_title(),
				'body' => $this->category->content()->get_body(),
				'link' => $system->url(Resource::Get_By_Argument($module, $url)->url())
			);
		}
		foreach($this->articles as $article){
			$template->articles[] = array(
				'title' => $article->brief()->get_title(),
				'llink' => $system->url(Resource::Get_By_Argument($module, $url . 'article/' . $article->id())->url()),
				'slink' => $system->url(Resource::Get_By_Argument($module, $url . 'list/1/article/' . $article->id())->url()),
				'body' => html_entity_decode(strip_tags($article->brief()->get_body()), ENT_COMPAT, 'UTF-8')
			);
		}
		return $template;
	}


}
