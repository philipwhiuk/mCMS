<?php

class News_Article {
	
	private $id;
	private $time;
	private $content;
	private $category;
	private $brief;

	public function brief(){
		if(!($this->brief instanceof Content)){
			$this->brief = Content::Get_By_ID($this->brief);
		}
		return $this->brief;
	}

	public function category(){
		if(!($this->category instanceof News_Category)){
			$this->category = News_Category::Get_By_ID($this->category);
		}
		return $this->category;
	}
	
	public function content(){
		if(!($this->content instanceof Content)){
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	
	public function id(){
		return $this->id;
	}
	
	public function author() {
		if(!$this->author instanceof User) {
			$this->author = User::Get_By_ID($this->author);
		}
		return $this->author;
	}
	
	public function time(){
		return $this->time;
	}
	public static function Get_All(){
		$query = MCMS::Get_Instance()
						->Storage()
						->Get()
						->From('news_article')
						->order(array('time' => false));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($offset)){
				$query->offset($offset);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('News_Article')){
			$return[] = $row;
		}
		return $return;
	}	
	public static function Get_By_Category($category, $limit = null, $offset = null){
		
		if($category instanceof News_Category){
			$category = $category->id();
		}
		
		$query = MCMS::Get_Instance()
						->Storage()
						->Get()
						->From('news_article')
						->where('=', array(array('col','category'), array('u', $category)))
						->order(array('time' => false));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($offset)){
				$query->offset($offset);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('News_Article')){
			$return[$row->id()] = $row;
		}
		
		return $return;
		
	}

	public static function Latest_By_Category($category){
		if($category instanceof News_Category){
			$category = $category->id();
		}
		//array('=', array(array('col','category'), array('u', $category))),

		$query = MCMS::Get_Instance()->Storage()
						->Get()
						->From('news_article')->where('=', array(array('col','category'), array('u', $category)))->order(array('time' => false))->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new News_Article_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('News_Article');
	}
		
	public static function Get_By_ID_Category($id, $category){
		if($category instanceof News_Category){
			$category = $category->id();
		}
		return self::Get_One('AND',array(
			array('=', array(array('col','id'), array('u', $id))),
			array('=', array(array('col','category'), array('u', $category))),
		));
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->Storage()
						->Get()
						->From('news_article')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new News_Article_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('News_Article');
		
	}
	public static function Count_All(){
		$query = MCMS::Get_Instance()->Storage()->Count()->From('news_article');
		return $query->execute();
	}
}
