<?php
/** 
	public function topic_count() {
		return $this->topic_count;	
	}
	public function post_count() {
		return $this->post_count;	
	}
	public function lastpostdate() {
		return $this->lastpostdate;	
	}
	public function lastpost() {
		return $this->lastpost;	
	}
	public function lastposter() {
		if(!$this->lastposter instanceof User) {
			$this->lastposter = User::Get_By_ID($this->lastposter);
		}
		return $this->lastposter;
	}
**/

class Forum_Page_Main_Forum_View extends Forum_Page_Main {
	public function __construct($forums,$forum,$parent) {
		$this->parents = $forums;
		$this->forum = $forum;
		$this->forum->content()->get_title();
		$this->forum->content()->get_body();
		$this->system = System::Get_Instance();
		$this->module = Module::Get('forum');
		/** Build the URL for the current forum **/
		$this->url_part = "";
		foreach($this->parents as $parent) { $this->url_part .= $parent->id().'/'; }
		$this->url_part .= $this->forum->id().'/';
		
		/** Sub Forum Retrieval **/
		/**  Start by getting the sub forums at each depth. Use the selected forum for the initial set **/
		$forums = array($this->forum->id());
		$sub_forums = array();
		for($i = 0; $i < $this->forum->depth(); $i++) {
			$sub_forums[$i] = Forum::Get_By_Parent_In($forums);
			$forums = array();
			/** Assign the retrieved forums from the previous level to the next level to use as parents.
				 **/
			foreach($sub_forums[$i] as $sub_forum) {
				$forums[] = $sub_forum->id();
			}
		}		
		/** Reverse through the levels, adding each forum to it's parent, unsetting the levels once finished.
			Do some retrieval here, so that you can abandon forums which throw exceptions.	**/
		for($i = $this->forum->depth()-1; $i > 0; $i--) {
			foreach($sub_forums[$i] as $sub_forum) {
				try {
					$sub_forum->content()->get_title();
					$sub_forum->content()->get_body();
					try {
						$sub_forum->lastposter()->get_name();
					}
					catch (Exception $e) {						
					}
					$sub_forum->topic_count = Forum_Topic::Count_By_Forum($sub_forum->id());
					$sub_forums[$i-1][$sub_forum->parent_id()]->children[] = $sub_forum;
				}
				catch (Exception $e) {

				}
			}
			unset($sub_forums[$i]);
		}
		/** Move the top level sub_forums to this object **/
		$this->sub_forums = $sub_forums[0];
		if($this->forum->has_topics()) {		
			try {
				$this->topics = Forum_Topic::Get_By_Forum($this->forum->id());
				foreach($this->topics as $topic) {
					$topic->topic()->get_content()->get_title();
					$topic->topic()->get_firstauthor();
					$topic->topic()->get_lastauthor();
				}
			}
			catch(Exception $e) {
				$this->topics = array();	
			}
		}
		$module = Module::Get('forum');
		$urlpart = "";
		foreach($this->parents as $parent) {
			$urlpart .= $parent->id().'/';	
		}
		$this->url = System::Get_Instance()->url(Resource::Get_By_Argument($module, $urlpart.$this->forum->id())->url());
	}
	public function display(){
		$system = System::Get_Instance();
		$usermodule = Module::Get('user');
		$forummodule = Module::Get('forum');
		$template = $system->output()->start(array('forum','page','forum','view'));
		$template->title = $this->forum->content()->get_title();
		$template->url = $this->url;
		$template->description = $this->forum->content()->get_body();
		$template->sub_forums = array();
		try {
			$template->parentID = $this->forum->parent()->id();
		}
		catch (Forum_Not_Found_Exception $e) {
			$template->parentID = 0;
		}
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

		foreach($this->sub_forums as $sub_forum) {
			if($this->forum->depth() > 0) {
				$template->sub_forums[] = $this->display_sf($sub_forum,$this->forum->depth(),$this->url);
			}
		}
		$template->has_topics = $this->forum->has_topics();
		if($this->forum->has_topics()) {
			$template->topic_add_url = $this->url.'topic/add';
			foreach($this->topics as $topic) {
				$t = array();
				$t['topicurl'] = $this->url.'topic/'.$topic->topic()->get_id();
				$t['title'] = $topic->topic()->get_content()->get_title();
				$t['posts'] = $topic->topic()->get_posts();
				$t['views'] = $topic->topic()->get_views();
				$t['firstposter'] = $topic->topic()->get_firstauthor()->get('display_name');
				$t['firstposterurl'] = $system->url(Resource::Get_By_Argument($usermodule,$topic->topic()->get_firstauthor()->get_id())->url());
				$t['firstpostdate'] = date('D M dS Y H:ia',$topic->topic()->get_firstdate());
				$t['lastposter'] = $topic->topic()->get_lastauthor()->name();
				$t['lastposterurl'] = $system->url(Resource::Get_By_Argument($usermodule,$topic->topic()->get_lastauthor()->get_id())->url());
				$t['lastpostdate'] = date('jS F Y',$topic->topic()->get_lastdate());
				$template->topics[] = $t;
			}
		}
		return $template;
	}
	private function display_sf($sub_forum,$depth,$parenturl) {
		$sf = array();
		$sf['url'] = $parenturl.$sub_forum->id().'/';
		$sf['title'] = $sub_forum->content()->get_title();
		$sf['description'] = $sub_forum->content()->get_body();
		$sf['topics'] = $sub_forum->topic_count;
		$sf['posts'] = $sub_forum->post_count;
//		try {
//			$sf['lastposter'] = $sub_forum->lastposter();
//			$sf['lastpost'] = $sub_forum->lastpost();
//			$sf['lastpostdate'] = $sub_forum->lastpostdate();
//			$sf['lastpost'] = true;
//		}
//		catch (Exception $e) {
			$sf['lastpost'] = false;
//		}
		$sf['url'] = $this->system->url(Resource::Get_By_Argument($this->module, $this->url_part . $sub_forum->id().'/view')->url());
		$sf['children'] = array();
		foreach($sub_forum->children as $ssf) {
			if($depth-1 > 0) {
				$sf['children'] = display_sf($ssf,$depth-1);
			}
		}
		return $sf;
	}	
}