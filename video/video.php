<?php

class Video {

	private $id;
	private $content;

	public function id(){
		return $this->id;
	}

	public function content(){
		if(!($this->content instanceof Content)){
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}

	static public function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->database()->Select()->table('video')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Video_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Video');		
	}
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('video');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('video')->order(array('id' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Video')){
			$return[] = $row;
		}
		
		return $return;
	}
}
