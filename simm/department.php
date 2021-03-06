<?php
class Simm_Department {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_department');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_department')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Department')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_department')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Department_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Department');
		
	}
	
	private $id;
	private $description;
	
	public function id() {
		return $this->id;
	}
	public function description() {
		if(!$this->description instanceof Content) {
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}
}