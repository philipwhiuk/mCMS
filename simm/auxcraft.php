<?php
class Simm_AuxCraft {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_auxcraft');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_auxcraft')->order(array('lastname' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_AuxCraft')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_auxcraft')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_AuxCraft_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_AuxCraft');
		
	}
	public static function Get_By_Parent($parent) {
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_auxcraft')->where('=', array(array('col','parent'), array('u', $parent)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_AuxCraft')){
			$return[] = $row;
		}
		
		return $return;
	}
	
	private $id;
	public function id() {
		return $id;
	}
}