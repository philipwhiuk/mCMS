<?php
class Simm_Character_Biography {
	private $id;
	private $character;
	private $content;
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_character_biography');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_character_biography')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Character_Biography')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_character_biography')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Character_Biography_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Character_Biography');
		
	}
	public static function Get_By_Character($character){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_character_biography')->where('=', array(array('col','character'), array('u', $character)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Character_Biography')){
			$return[] = $row;
		}
		
		return $return;
		
	}
}