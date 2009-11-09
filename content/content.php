<?php

class Content {
	
	private $id;
	private $title;
	private $body;
	
	public function get_title(){
		return $this->title;
	}
	
	public function get_body(){
		return $this->body;
	}
	
	public function id(){
		return $this->id;
	}
	
	public function update($data){
		$query = System::Get_Instance()->database()->Update()->table('content')
			->set(array(
					'title' => array('s', $data['title']),
					'body' => array('s', $data['body'])
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
		
		$query->execute();
	}
	
	public static function Get_All(){
		$query = System::Get_Instance()->database()->Select()->table('content');
		
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
		
		$query = System::Get_Instance()->database()->Select()->table('content')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Content_Not_Found_Exception($operator, $operand);
		}
		
		
		$site = $result->fetch_object('Content');
		
		return $site;
		
	}
}