<?php

class Film_Role {
	private $content;
	private $id;

	private function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	public function get_id(){
		return $this->id;
	}
	public function get_content(){
		if(!($this->content instanceof Content)){
			$this->content= Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->database()->Select()->table('film_role')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Actor_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Film_Role');
		
	}
	public static function Get_All(){
		$query = MCMS::Get_Instance()->database()->Select()->table('film_role');
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Role')){
			$return[] = $row;
		}
		return $return;
	}

}
