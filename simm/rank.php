<?php
class Simm_Rank {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_rank');
		return $query->execute();

	}
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_rank')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Rank')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_rank')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Rank_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Rank');
		
	}
	private $id;
	private $title;
	public function id() {
		return $this->id;
	}
	public function title() {
		return $this->title;
	}
}