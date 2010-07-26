<?php

class User {
	
	public function get_id(){
		return $this->id;
	}
	
	protected function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v;}
	}

	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public function get($key){
		if(!isset($this->$key)){
			throw new User_Key_Not_Found_Exception($key);	
		}
		return $this->$key;
	}	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('user')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new User_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('User');
		
		return $site;
		
	}
	public static function Count_All(){
		$query = System::Get_Instance()->database()->Count()->table('user');
		return $query->execute();
	}
	public static function Get_All($limit = null, $skip = null){
		$query = System::Get_Instance()->database()->Select()->table('user')->order(array('id' => true));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('User')){
			$return[] = $row;
		}
		return $return;
	}
	private $id;
	private $name;
	public function name() {
		return $this->name;	
	}
}
