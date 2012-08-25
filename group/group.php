<?php

class Group {
	
	private $id;
	private $name;
	public function get_id() {
		return $this->id;
	}
	public function get_name() {
		return $this->name;
	}
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('group');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('group')->order(array('name' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Group')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->database()->Select()->table('group')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Group_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Group');
	}
	public static function Get_By_User($user){
		return Group_User::Get_By_User($user);
	}
	
}
