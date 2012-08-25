<?php
class Simm_Fleet {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_fleet');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_fleet')->order(array('sort' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Fleet')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_fleet')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Fleet_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Fleet');
	}
	public static function Get_By_Parent($parent) {
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_fleet')->where('=', array(array('col','parent'), array('u', $parent)));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Fleet')){
			$return[] = $row;
		}
		
		return $return;
	}
	private $id;
	private $parent;
	private $description;
	private $shortcode;
	public function id() {
		return $this->id;
	}
	public function description() {
		if(!$this->description instanceof Content) {
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}
	public function shortcode() {
		return $this->shortcode;
	}
}