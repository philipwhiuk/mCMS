<?php
class Simm_Fleet_Simm {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_fleet_simm');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_fleet_simm')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Fleet_Simm')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_fleet_simm')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Fleet_Simm_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Fleet_Simm');
		
	}
	public static function Get_By_Fleet($fleet) {
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_fleet_simm')->where('=', array(array('col','fleet'), array('u', $fleet)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Fleet_Simm')){
			$return[] = $row;
		}
		
		return $return;
	}
	
	private $id;
	private $fleet;
	private $simm;
	
	public function id() {
		return $this->id;
	}
	public function fleet() {
		if(!$this->fleet instanceof Simm_Fleet) {
			$this->fleet = Simm_Fleet::Get_By_ID($this->fleet);
		}
		return $this->fleet;
	}
	public function simm() {
		if(!$this->simm instanceof Simm) {
			$this->simm = Simm::Get_By_ID($this->simm);
		}
		return $this->simm;
	}
}