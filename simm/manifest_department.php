<?php
class Simm_Manifest_Department {
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_manifest_department')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Department')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_department')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Manifest_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Manifest_Department');
		
	}
	public static function Get_By_Manifest($manifest){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_manifest_department')->where('=', array(array('col','manifest'), array('u', $manifest)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Manifest_Department')){
			$return[] = $row;
		}
		
		return $return;
		
	}
	
	private $id;
	private $manifest;
	private $department;
	
	public function id() {
		return $this->id;
	}
	public function manifest() {
		if(!$this->manifest instanceof Simm_Manifest) {
			$this->manifest = Simm_Manifest::Get_By_ID($this->manifest);
		}
		return $this->manifest;
	}
	public function department() {
		if(!$this->department instanceof Simm_Department) {
			$this->department = Simm_Department::Get_By_ID($this->department);
		}
		return $this->department;
	}
}