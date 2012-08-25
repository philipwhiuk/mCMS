<?php

class News_Category {
	
	private $id;
	private $content;
	private $parent;
	
	private $children;
	
	public function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	
	public function id(){
		return $this->id;
	}
	
	public function parents($parents = array()){
		$parents[] = $this->id;
		if($this->parent == 0){
			return $parents;
		} else {
			if(!($this->parent instanceof News_Category)){
				$this->parent = News_Categroy::Get_By_ID($this->parent);
			}
			return $this->parents($parents);
		}
	}
	
	public function content(){
		if(!($this->content instanceof Content)){
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	
	public function children(){
		if(!isset($this->children)){
			$this->children = News_Category::Get_By_Parent($this);
		}
		return $this->children;
	}
	
	public function articles($limit = null, $offset = null){
		if(!isset($this->articles)){
			$this->articles = News_Article::Get_By_Category($this, $limit, $offset);
		}
		return $this->articles;
	}
	
	public static function Get_By_Parent($parent){
		
		if($parent instanceof News_Category){
			$parent = $parent->id();
		}
		
		$query = MCMS::Get_Instance()->Storage()
						->Get()
						->From('news_category')
						->where('=', array(array('col','parent'), array('u', $parent)));
		
		$result = $query->execute();
		$return = array();
		
		while($row = $result->fetch_object('News_Category')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=',array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_By_ID_Parent($id, $parent){
		if($parent instanceof News_Category){
			$parent = $parent->id();
		}
		return self::Get_One('AND',array(
			array('=', array(array('col','id'), array('u', $id))),
			array('=', array(array('col','parent'), array('u', $parent))),
		));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->Storage()->Get()->From('news_category')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new News_Category_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('News_Category');
		
	}
	
}
