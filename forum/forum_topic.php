<?php
class Forum_Topic {
	private $forum;
	private $topic;
	private $movedate;
	private $moveforum;
	
	public forum() {
		if(!$this->forum instanceof Forum) {
			$this->forum = Forum::Get_By_ID($this->forum);	
		}
		return $this->forum;
	}
	public topic() {
		if(!$this->topic instanceof Topic) {
			$this->topic = Topic::Get_By_ID($this->topic);	
		}
		return $this->topic;
	}
	public movedate() {
		return $this->movedate;	
	}
	public moveforum() {
		return $this->moveforum;	
	}
	public static Get_By_Forum($forum,$limit = null, $skip = null) {
		$query = System::Get_Instance()->database()->Select()->table('forum_topic')->where('=', array(array('col','forum'), array('u', $forum)));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Forum_Topic')){
			$return[] = $row;
		}
		return $return;	
	}
	public static Get_By_Topic($topic,$limit = null, $skip = null) {
		$query = System::Get_Instance()->database()->Select()->table('forum_topic')->where('=', array(array('col','topic'), array('u', $topic)));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Forum_Topic')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Get_All($limit = null, $skip = null){
		$query = System::Get_Instance()->database()->Select()->table('forum_topic');
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Forum_Topic')){
			$return[] = $row;
		}
		return $return;
	}
}