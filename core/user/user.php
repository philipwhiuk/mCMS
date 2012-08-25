<?php

class User {
	
	public function get_id(){
		return $this->id;
	}
	public function local_username() {
		return $this->local_username;
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
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('user')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new User_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('User');
		
		return $site;
		
	}
	public static function Count_All(){
		$query = MCMS::Get_Instance()->storage()->Count()->From('user');
		return $query->execute();
	}
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->storage()->Get()->From('user')->order(array('id' => true));
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
	public function id() {
		return $this->id;
	}
	public function name() {
		return $this->name;	
	}
	public function Update($data){

		$query = MCMS::Get_Instance()->Storage()->Update()->From('user')
			->set(array('name' => array('s', $data['name'])
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
			
		$query->execute();
		
		$this->name = $data['name'];
	}
}
