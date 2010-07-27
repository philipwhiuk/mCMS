<?php

class News_Admin extends Admin {

	protected $parent;
	protected $mode;
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		$this->name = Language::Retrieve()->get($this->module, array('admin','menu','name'));
	}

	public function display(){
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'categories'){
			return $this->display_categories();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		} 
	}
	public function display_edit(){
		$template = System::Get_Instance()->output()->start(array('news','admin','edit'));
		$template->title = $this->news_article->content()->get_title();
		$template->form = $this->form->display();
		return $template;
	}
	public function display_list(){
		$template = System::Get_Instance()->output()->start(array('news','admin','list'));
		$template->content = array();
		$template->edit = $this->edit;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->news_article as $news_article){
			$template->news_article[] = array(
				'title' => $news_article->content()->get_title(),
				'edit' => $this->url('edit/' . $news_article->id())
			);
		}
		return $template;
	}
	public function display_menu(){
		$template = System::Get_Instance()->output()->start(array('news','admin','menu'));
		$template->url = $this->url;
		$template->name = $this->name;
		return $template;
	}
	public function execute($parent){
		$this->parent = $parent;
		$arg = $this->parent->resource()->get_argument();
		try {
			if($arg == 'list'){
				$this->parent->resource()->consume_argument();
				$this->execute_list();
				return;
			} elseif($arg == 'categories') {
				$this->parent->resource()->consume_argument();
				$this->execute_categories();
				return;
			} elseif($arg == 'edit'){
				$this->parent->resource()->consume_argument();
				$this->execute_edit();
				return;
			}
		} catch(Exception $e){
			var_dump($e);
		}
		$this->execute_list();
	}
	public function execute_edit(){
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->news_article = News_Article::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();
		$language = Language::Retrieve();
		$this->form = new Form(array('news',$this->news_article->id(), 'admin'), $this->url('edit/' . $this->news_article->id()));

		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$title->set_value($this->news_article->content()->get_title());

		$time = Form_Field::Create('time', array('textbox'));
		$time->set_label($language->get($this->module, array('admin','edit','time')));
		$time->set_value($this->news_article->time());
		
		$brief = Form_Field::Create('brief', array('richtext','textarea'));
		$brief->set_label($language->get($this->module, array('admin','edit','brief')));
		$brief->set_value($this->news_article->brief()->get_body());
		
		$content = Form_Field::Create('content', array('richtext','textarea'));
		$content->set_label($language->get($this->module, array('admin','edit','content')));
		$content->set_value($this->news_article->content()->get_body());

		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));

		$this->form->fields($title,$time,$brief,$content,$submit);
	}
	public function execute_list(){
		$this->mode = 'list';  
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
			if($news_articles[$i] instanceof News_Article) { $this->news_article[] = $news_articles[$i]; }
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
}