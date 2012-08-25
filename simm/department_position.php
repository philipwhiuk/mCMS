<?php
class Simm_Department_Position {
	private $id;
	private $department;
	private $position;
	public static function Get_By_Department($department){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_department_position')->where('=', array(array('col','department'), array('u', $department)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Department_Position')){
			$return[] = $row;
		}
		
		return $return;
		
	}
	public static function Get_By_Position($position){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_department_position')->where('=', array(array('col','position'), array('u', $position)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Department_Position')){
			$return[] = $row;
		}
		
		return $return;
		
	}
	public function id() {
		return $this->id;
	}
	public function position() {
		if(!$this->position instanceof Simm_Position) {
			$this->position = Simm_Position::Get_By_ID($this->position);
		}
		return $this->position;
	}
	public function department() {
		if(!$this->department instanceof Simm_Department) {
			$this->department = Simm_Department::Get_By_ID($this->department);
		}
		return $this->department;
	}
}