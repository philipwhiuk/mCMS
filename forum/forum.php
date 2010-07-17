<?php
class Forum {
	private $id;
	private $content;
	private $language;
	private $parent;
	private $depth;
	
	private $children = array();

	private function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	public get_id() {
		return $this->id;
	}
	public get_content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_Id($this->content);
		return $this->name;
	}
	public get_language() {
		if(!$this->language instanceof Language) {
			$this->language = Language::Get_By_Id($this->language);
		}
		return $this->language;
	}
	public get_parentid() {
		if($this->parent instanceof Forum) {
			return $this->parent->id();
		}
		else {
			return $this->parent;
		}
	}	
	public get_parent() {
		if(!$this->parent instanceof Forum) {
			$this->parent = Forum::Get_By_ID($this->parent);
		}
		return $this->parent;
	}
	public depth() {
		return $this->depth;	
	}
	
	public static Get_By_ID($id) {
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
	public static Get_By_Parent($parent) {
		$query = System::Get_Instance()->database()->Select()->table('forum')->where('=', array(array('col','parent'), array('u', $parent));
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
	public static Get_All() {
		$query = System::Get_Instance()->database()->Select()->table('forum')->order(array('title' => true));
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
}