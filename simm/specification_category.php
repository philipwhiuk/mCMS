<?php
class Simm_Specification_Category {
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('simm_specification_category');
		return $query->execute();

	}
	
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('simm_specification_category')->order(array('id' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Simm_Specification_Category')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('simm_specification_category')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Simm_Specification_Category_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Simm_Specification_Category');
		
	}
	private $id;
	private $description;
	private $type;
	public function description() {
		if(!$this->description instanceof Content) {
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}
	public function type() {
		if(!$this->type instanceof Simm_Specification_Type) {
			$this->type = Simm_Specification_Type::Get_By_ID($this->type);
		}
		return $this->type;	
	}

}