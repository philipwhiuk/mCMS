<?php
class Film_Feature_Category {
	private $id;
	public function get_id() {
		return $this->id;
	}
	public static function Get_By_ID($id) {
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('film_feature_category')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Film_Feature_Category_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Film_Feature_Category');
	}
}