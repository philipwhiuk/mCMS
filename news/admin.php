<?php
abstract class News_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	private $pages;
	private $news_articles = array();
	
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new News_Admin_Menu($panel,$parent);
	}
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'category':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/category');					
					return News_Admin_Category::Load_Main($panel,$parent);
					break;
				case 'article':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/article');				
					return News_Admin_Article::Load_Main($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/article');		
			return News_Admin_Article::Load_Main($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('news'), array('view','edit','add','delete','list','admin'),'admin');
	}
	public function display_edit(){
		$template = MCMS::Get_Instance()->output()->start(array('news','admin','edit'));
		$template->title = $this->news_article->content()->get_title();
		$template->form = $this->form->display();
		return $template;
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
}