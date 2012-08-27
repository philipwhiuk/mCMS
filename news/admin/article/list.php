<?php
class News_Admin_Article_List extends News_Admin_Article {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$page = $arg;
		}
		else {
			$page = 1;
		}
		$news_articles = News_Article::Get_All();
		if(!(($page-1)*20 <= count($news_articles))) {
			$page = (int) (count($news_articles)/20)-1;
		}
		$this->news_article = array();
		for($i = ($page-1)*20; $i < $page*20 && $i < count($news_articles); $i++) {
			if($news_articles[$i] instanceof News_Article) { $this->news_articles[] = $news_articles[$i]; }
		}
		$this->page = $page;
		$count = News_Article::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('list/' . $pg);
		}	
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('admin','list','edit'));
		$this->title = $language->get($this->module, array('admin','list','title'));
	}

	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('news','admin','article','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->news_articles as $news_article){
			$template->news_articles[] = array(
				'title' => $news_article->content()->get_title(),
				'edit' => $this->url('edit/' . $news_article->id())
			);
		}
		return $template;
	}
}