<?php
class Simm_Manifest_Character {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_manifest_character');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_manifest_character')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Character')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_character')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Manifest_Position_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Manifest_Character');
		
	}
	public static function Get_By_Manifest_Position($manifest_position){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_character')->where('=', array(array('col','manifest_position'), array('u', $manifest_position)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Character')){
			$return[] = $row;
		}
		
		return $return;
		
	}
	public static function Get_By_Character($character) {
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_character')->where('=', array(array('col','character'), array('u', $character)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Character')){
			$return[] = $row;
		}
		
		return $return;
	}
	public function id() {
		return $this->id;
	}
	public function manifest_position() {
		if(!$this->manifest_position instanceof Simm_Manifest_Position) {
			$this->manifest_position = Simm_Manifest_Position::Get_By_ID($this->manifest_position);
		}
		return $this->manifest_position;
	}
	public function character() {
		if(!$this->character instanceof Simm_Character) {
			$this->character = Simm_Character::Get_By_ID($this->character);
		}
		return $this->character;
	}
}