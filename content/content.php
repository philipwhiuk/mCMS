<?php

class Content {
	
	private $id;
	private $title;
	private $body;
	
	private function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	
	public function get_title(){
		return $this->title;
	}
	
	public function get_body(){
		return $this->body;
	}
	
	public function id(){
		return $this->id;
	}
	
	public function Add($data){
		$database = System::Get_Instance()->database();
		$query = $database->insert()->table('content')
			->set(array(
					'title' => array('s', $data['title']),
					'body' => array('s', $data['body'])
			));
		
		$query->execute();
		
		return new Content(array(
			'title' => $data['title'],
			'body' => $data['body'],
			'id' => $database->insert_id		// TODO: Fix!
		));
	}
	
	public function update($data){
		$query = System::Get_Instance()->database()->Update()->table('content')
			->set(array(
					'title' => array('s', $data['title']),
					'body' => array('s', $data['body'])
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
			
		$query->execute();
		
		$this->title = $data['title'];
		$this->body = $data['body'];
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