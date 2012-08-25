<?php

class News_Page_Main_Category_List extends News_Page_Main {
	
	private $category;
	private $categories = array();
	private $articles = array();
	private $selected = false;
	
	public function __construct($parent, $category){
		parent::__construct($parent);
		if($category instanceof News_Category){
			Permission::Check(array('news/category',$category->id()), array('view','edit','add','delete','list'),'list');
			$category->content();
			$this->category = $category;
			$this->categories = $category->children();
			$arg = $this->parent->resource()->get_argument();
			if(is_numeric($arg)){
				$this->page = ((int) $arg);
				$this->parent->resource()->consume_argument();
				$this->articles = $category->articles(6, 5 * (((int) $arg) - 1));
			} else {
				$this->page = 1;
				$this->articles = $category->articles(6);
			}
		} else {
			Permission::Check(array('news/category',$category), array('view','edit','add','delete','list'),'list');
			$this->categories = News_Category::Get_By_Parent($category);
			$arg = $this->parent->resource()->get_argument();
			if((int) $arg != 0){
				$this->page = ((int) $arg);
				$this->parent->resource()->consume_argument();
				$this->articles = News_Article::Get_By_Category($category, 6, 5 * (((int) $arg) - 1));
			} else {
				$this->page = 1;
				$this->articles = News_Article::Get_By_Category($category, 6);
			}
		}
		foreach($this->categories as $child){
			$child->content();
		}
		foreach($this->articles as $article){
			$article->content();
		}
		$arg = $this->parent->resource()->get_argument();
		reset($this->articles);
		$this->selected = current($this->articles);
		if($arg == 'article'){
			$this->parent->resource()->consume_argument();
			$arg = (int) $this->parent->resource()->get_argument();
			if(isset($this->articles[$arg])){
				$this->selected = $this->articles[$arg];
			}
		}
	}
	
	public function display(){
		
		$system = MCMS::Get_Instance();
		$template = $system->output()->start(array('news','page','category','list'));
		
		$language = Language::Retrieve();
				
		$module = Module::Get('news');
		$template->uncategorised = array('title' => 'Uncategorised', 'url' => $system->url(Resource::Get_By_Argument($module, 0)->url()));
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
				'url' => $system->url(Resource::Get_By_Argument($module, $url . $category->id())->url())
			);
		}
		
		$df = $language->get($module, array('category','list', 'date'));
		$i = 0;
		foreach($this->articles as $article){
			$i ++;
			if($i <= 5){
				$tArticle = array();
				$tArticle['id'] = $article->id();
				$tArticle['author'] = $article->author()->get('display_name');
				$tArticle['title'] = $article->content()->get_title();
				try {
					$tArticle['brief'] = $article->brief()->get_body();
				} catch (Content_Not_Found_Exception $e) {
					$tArticle['brief'] = '';
				}
				$tArticle['categories'] = array();
				try {
					$tCat = array();
					$tCat['url'] = $system->url(Resource::Get_By_Argument($module, $article->category()->id())->url());
					$tCat['title'] = $article->category()->content()->get_title();
					$tArticle['categories'][] = $tCat;
				} catch (Exception $e) {
					var_dump($e);
				}
				$tArticle['body'] = $article->content()->get_body();
				$tArticle['time'] = date($df, $article->time());
				$tArticle['selected'] = ($this->selected == $article);
				$tArticle['furl'] = $system->url(Resource::Get_By_Argument($module, $url . 'article/' . $article->id())->url());
				$tArticle['editurl'] = $system->url(Resource::Get_By_Argument($module, $url . 'article/' . $article->id().'/edit')->url());
				$tArticle['surl'] = $system->url(Resource::Get_By_Argument($module, $url . 'list/' . $this->page . '/article/' . $article->id())->url());
			
				$template->articles[] = $tArticle;
			}
		}
	
		if($this->page != 1){
			$template->previous = array(
				'url' => $system->url(Resource::Get_By_Argument($module, $url . 'list/' . ($this->page - 1))->url())
			);
		} else {
			$template->previous = false;
		}

		if($i > 5){
			$template->next = array(
				'url' => $system->url(Resource::Get_By_Argument($module, $url . 'list/' . ($this->page + 1))->url())
			);
		} else {
			$template->next = false;
		}

		if($this->selected){
			$template->selected = array(
				'title' => $this->selected->content()->get_title(),
				'body' => $this->selected->content()->get_body(),
				'time' => date($df, $this->selected->time()),
				'furl' => $system->url(Resource::Get_By_Argument($module, $url . 'article/' . $this->selected->id())->url())
			);
		}		
		
		return $template;
	}
	
}
