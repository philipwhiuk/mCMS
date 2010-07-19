<?php

abstract class Forum_Page_Main extends Page_Main {
	public static function Load($parent){
		$exceptions = array();
		$forum = null;
		$forums = array();
		$arg = $parent->resource()->get_argument();
		try {
			$parents = array();
			while(is_numeric($arg)){
				$nforum = Forum::Get_By_ID_Parent($arg, isset($forum) ? $forum->id() : 0);
				if(isset($forum)) { $forums[] = $forum; }
				$forum = $nforum;
				$parent->resource()->consume_argument();
				$arg = $parent->resource()->get_argument();
			}
			
			if(isset($forum) && $arg == 'topic'){
				$parent->resource()->consume_argument();
				$arg = $parent->resource()->get_argument();
				if(is_numeric($arg)){
					try {
						return Forum_Page_Main::Load_Topic($forums,$forum,$arg,$parent); 
					}
					catch(Exception $e){
						var_dump($e);	
					}
				} elseif($arg == 'add'){
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('page_main/topic_add');
				}
			}
		} catch(Exception $e){
			$exceptions[] = $e;
		}
		try {
			if(isset($forum)){
				return Forum_Page_Main::Load_Forum($forums,$forum,$parent);
			} elseif($arg == 'add') {
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/forum_add');
			}
		} catch(Exception $e){
			$exceptions[] = $e;	
		}
		throw new Forum_Page_Main_Exception($exceptions);
	}
	private function Load_Forum($forums,$forum,$parent) {
		$arg = $parent->resource()->get_argument();
		if($arg == 'edit') {
			$parent->resource()->consume_argument();
			$parent->resource()->get_module()->file('page_main/forum_edit');
			return new Forum_Page_Main_Forum_Edit($forums,$forum,$parent);
		}
		else {
			if($arg == 'view') {
				$parent->resource()->consume_argument();
			}
			$parent->resource()->get_module()->file('page_main/forum_view');
			return new Forum_Page_Main_Forum_View($forums,$forum,$parent);
		}
	}	
	private function Load_Topic($forums,$forum,$topicid,$parent) {
		$topic = Forum_Topic::Get_By_Forum_Topic($forum->id(),$topicid);
		$parent->resource()->consume_argument();
		$arg = $parent->resource()->get_argument();
		try {
			if(is_numeric($arg)) {	//postID
				$post = arg;
				return Forum_Page_Main::Load_Post($forums,$topic,$post,$parent);
			}
			elseif($arg == 'reply') {
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/topic_reply');
				return new Forum_Page_Main_Topic_Reply($forums,$forum,$topic,$parent);
			}
			elseif($arg == 'move') {
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/topic_move');
				return new Forum_Page_Main_Topic_Move($forums,$forum,$topic,$parent);
			}
			elseif($arg == 'lock') {
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/topic_lock');
				return new Forum_Page_Main_Topic_Lock($forums,$forum,$topic,$parent);
			}
			elseif($arg == 'hide') {
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/topic_lock');
				return new Forum_Page_Main_Topic_Lock($forums,$forum,$topic,$parent);
			}
			elseif($arg == 'delete') {
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/topic_delete');
				return new Forum_Page_Main_Topic_Delete($forums,$forum,$topic,$parent);
			}
			if($arg == 'view') {
				$parent->resource()->consume_argument();
			}
		}
		catch(Exception $e) {
			$exceptions[] = $e;
		}
		$parent->resource()->get_module()->file('page_main/topic_view');
		return new Forum_Page_Main_Topic_View($forums,$forum,$topic,$parent);
	}
	private function Load_Post($forums,$topic,$post,$parent) {
		$parent->resource()->consume_argument();
		$arg = $parent->resource()->get_argument();
		if($arg == 'edit') {
			$parent->resource()->consume_argument();
			$parent->resource()->get_module()->file('page_main/topic_post_edit');
			return new Forum_Page_Main_Topic_Post_Edit($forums,$topic,$post,$parent);
		}
		elseif($arg == 'split') {
			$parent->resource()->consume_argument();
			$parent->resource()->get_module()->file('page_main/topic_post_split');
			return new Forum_Page_Main_Topic_Post_Split($forums,$topic,$post,$parent);
		}
		elseif($arg == 'hide') {
			$parent->resource()->consume_argument();
			$parent->resource()->get_module()->file('page_main/topic_post_hide');
			return new Forum_Page_Main_Topic_Post_Hide($forums,$topic,$post,$parent);							
		}
		elseif($arg == 'reply') {
			$parent->resource()->consume_argument();
			$parent->resource()->get_module()->file('page_main/topic_post_reply');
			return new Forum_Page_Main_Topic_Post_View($forums,$topic,$post,$parent);
		}
		else {
			if($arg == 'view') {
				$parent->resource()->consume_argument();
			}
			$parent->resource()->get_module()->file('page_main/topic_post_view');
			return new Forum_Page_Main_Topic_Post_View($forums,$topic,$post,$parent);
		}		
	}
}