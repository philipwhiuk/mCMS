<?php
class Forum_Page_Main_Forum_View extends Forum_Page_Main {
	public function __construct($forums,$forum,$parent) {
		$this->parents = $forums;
		$this->forum = $forum;
		$this->forum->content()->title();
		$this->forum->content()->body();
		$this->system = System::Get_Instance();
		$this->module = Module::Get('forum');
		/** Build the URL for the current forum **/
		$this->url_part = "";							
		foreach($this->parents as $parent) { $this->url_part .= $parent->id().'/'; }
		$this->url_part .= $this->forum->id().'/';
		
		/** Sub Forum Retrieval **/
		/**  Start by getting the sub forums at each depth. Use the selected forum for the initial set **/
		$forums = array($this->forum->id());					
		for($i = 0; $i < $this->forum->depth(); $i++) {
			$sub_forums[$i] = Forum::Get_By_Parent_In($forums);
			$forums = array();
			/** Assign the retrieved forums from the previous level to the next level to use as parents.
				Do some retrieval here, so that you can abandon forum stacks which throw exceptions.	 **/
			foreach($sub_forums[$i] as $sub_forum) {
				$sub_forum->content()->title();
				$sub_forum->content()->body();
				$forums[] = $sub_forum->id();
				
			}
		}		
		/** Reverse through the levels, adding each forum to it's parent, unsetting the levels once finished.**/
		for($i = $this->forum->depth()-1; $i > 0; $i--) {
			foreach($sub_forums[$i] as $sub_forum) {
				$sub_forums[$i-1][$sub_form->parent_id()]->children[] = $sub_forum;
			}
			unset($sub_forums[$i]);
		}
		/** Move the top level sub_forums to this object **/
		$this->sub_forums = $sub_forums[0];
		
		$this->topics = Forum_Topic::Get_By_Forum($this->forum->id());
		foreach($this->topics as $topic) {
			$topic->get_content()->title();
			$topic->get_firstauthor();
			$topic->get_lastauthor();
		}		
	}
	public function display(){
		$template = $this->system->output()->start(array('forum','page','forum','view'));
		$template->title = $this->forum->content()->title();
		$template->description = $this->forum->content()->body();
		$template->sub_forums = array();
		foreach($this->sub_forums as $sub_forum) {
			if($this->forum->depth() > 0) {
				$template->sub_forums[] = display_sf($sub_forum,$this->forum->depth());
			}
		}
	}
	private function display_sf($sub_forum,$depth) {
		$sf = array();
		$sf['title'] = $sub_forum->content()->title();
		$sf['description'] = $sub_forum->content()->body();
		$sf['topics'] = $sub_forum->topic_count();
		$sf['posts'] = $sub_forum->post_count();
		$sf['lastpostdate'] = $sub_forum->lastpostdate();
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