<?php
class Topic_Post {
	private $id;
	private $content;
	private $author;
	private $date;
	private $editauthor;
	private $editdate;
	private $topic;
	private $parent;
	
	public function get_id() {
		return $this->id;
	}
	public function get_content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public function get_author() {
		if(!$this->author instanceof User) {
			$this->user = User::Get_By_ID($this->user);
		}
		return $this->content;
	}
	public function get_date() {
		return $this->date;
	}
	public function get_editauthor() {
		if(!$this->author instanceof User) {
			$this->user = User::Get_By_ID($this->user);
		}
		return $this->content;
	}
	public function get_editdate() {
		return $this->date;
	}
	public function get_topic() {
		if(!$this->topic instanceof Topic) {
			$this->topic = Topic::Get_By_ID($this->topic);
		}
		return $this->topic;
	}
	public function get_parent() {
		if(!$this->parent instanceof Post) {
			$this->parent = Post::Get_By_ID($this->parent);
		}
	}
	public static function Get_By_ID($id) {
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('topic_post')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Post_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Topic_Post');
	}
	public static function Get_By_Topic($topic) {
		$query = System::Get_Instance()->database()->Select()->table('topic_post')->where('=', array(array('col','topic'), array('u', $topic));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Topic_Post')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Get_By_Parent($parent) {
		$query = System::Get_Instance()->database()->Select()->table('topic_post')->where('=', array(array('col','parent'), array('u', $parent));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Topic_Post')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Get_All() {
		$query = System::Get_Instance()->database()->Select()->table('topic_post')->order(array('date' => true));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Topic_Post')){
			$return[] = $row;
		}
		return $return;
	}
}
	