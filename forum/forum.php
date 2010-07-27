<?php
class Forum {
	private $id;
	private $content;
	private $language;
	private $parent;
	private $depth;
	public $topic_count;
	public $post_count;
	
	public $children = array();

	private function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	public function id() {
		return $this->id;
	}
	public function content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_Id($this->content);
		}
		return $this->content;
	}
	public function language() {
		if(!$this->language instanceof Language) {
			$this->language = Language::Get_By_Id($this->language);
		}
		return $this->language;
	}
	public function parent_id() {
		if($this->parent instanceof Forum) {
			return $this->parent->id();
		}
		else {
			return $this->parent;
		}
	}
	public function has_topics() {
		return (bool) $this->has_topics;
	}
	public function parent() {
		if(!$this->parent instanceof Forum) {
			$this->parent = Forum::Get_By_ID($this->parent);
		}
		return $this->parent;
	}
	public function depth() {
		return $this->depth;	
	}
	public static function Get_By_ID($id) {
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('forum')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Forum_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Forum');
	}
	public static function Get_By_ID_Parent($id,$parent) {
		$operator = 'AND';
		$operand = array(array('=', array(array('col','id'), array('u', $id))),array('=', array(array('col','parent'), array('u', $parent))));
		$query = System::Get_Instance()->database()->Select()->table('forum')->where($operator,$operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Forum_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Forum');
	}
	public static function Get_By_Parent_In($parents) {
		$in = array();
		$in[] = 'u';
		if(count($parents) == 0) {
			return array();
		}
		foreach($parents as $parent) { $in[] = $parent; }
		$query = System::Get_Instance()->database()->Select()->table('forum')->where(
			'in', 
			array(
				  array('col','parent'), 
				  $in
			)
		)->order(array('sort'=> true));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Forum')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Get_By_Parent($parent) {
		$query = System::Get_Instance()->database()->Select()->table('forum')->where('=', array(array('col','parent'), array('u', $parent)));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Forum')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Get_All() {
		$query = System::Get_Instance()->database()->Select()->table('forum');
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Forum')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Count_All(){
		$query = System::Get_Instance()->database()->Count()->table('forum');
		return $query->execute();
	}
}