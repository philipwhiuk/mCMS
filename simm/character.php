<?php
class Simm_Character {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_character');
		return $query->execute();

	}
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_character')->order(array('rank' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Character')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_Where($operator, $operand, $limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_character')->where($operator, $operand)->order(array('lastname' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Character')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_character')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Character_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Character');
		
	}

	private $id;
	private $lastname;
	private $firstname;
	private $middlename;
	private $rank;
	private $age;
	private $species;
	
	
	public function id() {
		return $this->id;
	}
	public function lastname() {
		return $this->lastname;
	}
	public function firstname() {
		return $this->firstname;
	}
	public function middlename() {
		return $this->middlename;
	}	
	public function rank() {
		if(!$this->rank instanceof Simm_Rank) {
			$this->rank = Simm_Rank::Get_By_ID($this->rank);
		}
		return $this->rank;
	}
	public function age() {
		return $this->age;
	}
	public function species() {
		return $this->species;
	}
}