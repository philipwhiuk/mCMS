<?php

class News_Page_Main_Article_View extends News_Page_Main {
	
	private $article;

	protected function check($mode){
		$cid = $this->category->id();
		$aid = $this->article->id();
		$perms = Permission::Check(array('news',$cid.'/article.'.$cid), array('view','edit','add','delete'),'view');
		$system = MCMS::Get_Instance();
		$language = Language::Retrieve();
		$module = Module::Get('news');

		$this->modes = array();
		foreach($perms as $k => $allowed){
			if($allowed && in_array($k, array('view','edit','delete'))){
				// Create linkage.
				// Link to content/id/mode - grab language junk
				$res = Resource::Get_By_Argument(Module::Get('news'),$cid .'/article/'.$aid.'/' . $k);
				$this->modes[$k] = array(
					'label' => $language->get($module, array('modes',$k)),
					'url' => $system->url($res->url()),
					'selected' => ($mode == $k)
				);
			}
		}
		// can now throw $this->modes at display :-)
	}
	
	public function __construct($parent, $category, $article){
		try {
		parent::__construct($parent);
		
		Permission::Check(array('news/category',$article->id()), array('view','edit','add','delete'),'view');
		$this->category = $category;
		$this->article = $article;
		$this->article->content();
		$this->check('view');
		}
		catch(Exception $e) {
			var_dump($e);
			exit();
		}
	}
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('news','page','article','view'));
		$system = MCMS::Get_Instance();
		$language = Language::Retrieve();
		$module = Module::Get('news');
		$template->uncategorised = array('title' => 'Uncategorised', 'url' => $system->url(Resource::Get_By_Argument($module, 'category/'. 0)->url()));
		try {
			$template->category = array(
				'title'	=> $this->article->category()->content()->get_title(),
				'body'	=> $this->article->category()->content()->get_body()
			);
			$url = join('/', $this->category->parents()) . '/';
		} catch (News_Category_Not_Found_Exception $e) {
			$template->category = array(
				'title'	=> $language->get($module, array('category','list','title')),
				'body'	=> $language->get($module, array('category','list','body'))
			);
			$url = '';
		}
		$template->categories = array();
		try {
			$tCat = array();
			$tCat['url'] = $system->url(Resource::Get_By_Argument($module, $this->article->category()->id())->url());
			$tCat['title'] = $this->article->category()->content()->get_title();
			$template->categories[] = $tCat;
		} catch (Exception $e) {
			var_dump($e);
		}
		$df = $language->get($module, array('category','list', 'date'));
		$template->modes = $this->modes;
		$template->id = $this->article->id();
		$template->furl = $system->url(Resource::Get_By_Argument($module, $url . 'article/' . $this->article->id())->url());
		$template->author = $this->article->author()->get('display_name');
		$template->title = $this->article->content()->get_title();
		$template->body = $this->article->content()->get_body();
		$template->time = date($df, $this->article->time());
		return $template;
	}
}