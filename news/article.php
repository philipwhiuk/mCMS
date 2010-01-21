<?php

class News_Article {
	
	private $id;
	private $time;
	private $content;
	private $category;
	
	public function content(){
		if(!($this->content instanceof Content)){
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	
	public function id(){
		return $this->id;
	}
	
	public function time(){
		return $this->time;
	}
	
	public static function Get_By_Category($category){
		
		if($category instanceof News_Category){
			$category = $category->id();
		}
		
		$query = System::Get_Instance()
						->database()
						->Select()
						->table('news_articles')
						->where('=', array(array('col','category'), array('u', $category)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('News_Article')){
			$return[] = $row;
		}
		
		return $return;
		
	}

	public static function Latest_By_Category($category){
		if($category instanceof News_Category){
			$category = $category->id();
		}
		//array('=', array(array('col','category'), array('u', $category))),

		$query = System::Get_Instance()->database()->Select()->table('news_articles')->where('=', array(array('col','category'), array('u', $category)))->order(array('time' => true))->limit(1);
		
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
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('news_articles')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new News_Article_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('News_Article');
		
	}
	
}
