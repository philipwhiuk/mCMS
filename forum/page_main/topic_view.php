<?php
class Forum_Page_Main_Topic_View extends Forum_Page_Main {
	public function __construct($parents,$forum,$topic,$parent) {
		$this->topic = $topic;
		$this->forum = $forum;
		$this->parents = $parents;
		$this->posts = array();
		$limit = 20;
		$arg = $parent->resource()->get_argument();
		if(is_numeric($arg)) {
			$skip = ($arg-1)*20;
		}
		else {
			$skip = 0;
		}
		$this->posts = Topic_Post::Get_By_Topic($this->topic->topic()->get_id(),$limit,$skip);
		$module = Module::Get('forum');
		$urlpart = "";
		foreach($this->parents as $parent) {
			$urlpart .= $parent->id().'/';	
		}
		$this->forumurl = System::Get_Instance()->url(Resource::Get_By_Argument($module, $urlpart.$this->forum->id())->url());
		$this->topicurl = $this->forumurl.'topic/'.$this->topic->topic()->get_id().'/';
	}
	public function display() {
		try {
			$system = System::Get_Instance();
			$usermodule = Module::Get('user');
			$forummodule = Module::Get('forum');
			$template = $system->output()->start(array('forum','page','topic','view'));
			foreach($this->parents as $parent) {
				$pa = array();
				$pa['title'] = $parent->content()->get_title();
				if(!isset($parenturl)) {
					$parenturl = System::Get_Instance()->url(Resource::Get_By_Argument($forummodule,$parent->id())->url());
					$pa['url'] = $parenturl;
				}
				else {
					$pa['url'] = $parenturl.$parent->id().'/';
				}				
				$template->parents[] = $pa;
			}
			$template->forum['title'] = $this->forum->content()->get_title();
			$template->forum['url'] = $this->forumurl;
			$template->title = $this->topic->topic()->get_content()->get_title();
			$template->description = $this->topic->topic()->get_content()->get_body();
			$template->pagecount = 1; // Add Pagecount
			$template->pages = array(); // Add Pages
			foreach($this->posts as $post) {
				$p = array();
				$p['title'] = $post->get_content()->get_title();
				$p['body'] = $post->get_content()->get_body();
				$p['author'] = array();
				$p['author']['name'] = $post->get_author()->name();
				$p['author']['url'] = $system->url(Resource::Get_By_Argument($usermodule,$post->get_author()->get_id())->url());
				$p['author']['signature'] = "";
				$p['date'] = date('jS F Y',$post->get_date());
				$p['url'] = $this->topicurl.'post/'.$post->get_id().'/';
				try {
					$p['editauthor'] = $post->get_editauthor()->name();
					$p['editdate'] = date('jS F Y',$topic->topic()->get_editdate());
					$p['edit'] = true;
				}
				catch (Exception $e) {
					$p['edit'] = false;
				}
				$template->posts[] = $p;
			}
			return $template;
		}
		catch(Exception $e) {
			var_dump($e);
			throw new Forum_Page_Main_Exception($e);
		}
	}
}