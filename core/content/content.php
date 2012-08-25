<?php
class Content {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('content');
		return $query->execute();

	}
	public static function Count_Published(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('content')->where('=', array(array('col','published'), array('u', 1)));
		return $query->execute();

	}
	public static function Get_Published($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('content')->where('=', array(array('col','published'), array('u', 1)))->order(array('title' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Content')){
			$return[] = $row;
		}
		
		return $return;
	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('content')->order(array('title' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Content')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('content')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Content_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Content');
		
	}
	
	private $id;
	private $title;
	private $body;
	private $published = false;
	
	public function get_title(){
		return $this->title;
	}
	
	public function get_body(){
		return $this->body;
	}
	public function published(){
		return $this->published;
	}
	
	public function id(){
		return $this->id;
	}	
	public function Update($data){

		$query = MCMS::Get_Instance()->Storage()->Update()->From('content')
			->set(array(
					'title' => array('s', $data['title']),
					'body' => array('s', $data['body'])
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
			
		$query->execute();
		
		$this->title = $data['title'];
		$this->body = $data['body'];
	}
}