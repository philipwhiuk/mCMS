<?php
class Simm_Manifest_Position {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_manifest_position');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_manifest_position')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Position')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_position')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Manifest_Position_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Manifest_Position');
		
	}
	public static function Get_By_Manifest_Department($manifest_department){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_position')->where('=', array(array('col','manifest_department'), array('u', $manifest_department)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Position')){
			$return[] = $row;
		}
		
		return $return;
		
	}
	public static function Get_By_Position($position){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_position')->where('=', array(array('col','position'), array('u', $position)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Position')){
			$return[] = $row;
		}
		
		return $return;
		
	}
	private $id;
	private $manifest_department;
	private $position;
	private $count_open;
	public function id() {
		return $this->id;
	}
	public function manifest_department() {
		if(!$this->manifest_department instanceof Simm_Manifest_Department) {
			$this->manifest_department = Simm_Manifest_Department::Get_By_ID($this->manifest_department);
		}
		return $this->manifest_department;
	}
	public function position() {
		if(!$this->position instanceof Simm_Position) {
			$this->position = Simm_Position::Get_By_ID($this->position);
		}
		return $this->position;
	}
	public function count_open() {
		return $this->count_open;
	}
}