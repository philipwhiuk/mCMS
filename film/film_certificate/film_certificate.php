<?php
class Film_Certificate {
	private $id;
	private $image;
	public function get_id() {
		return $this->id;
	}
	public function get_image() {
		if(!$this->image instanceof Image) {
			$this->image = Image::Get_By_ID($this->image);
		}
		return $this->image;
	}
	public static function Get_By_ID($id) {
		$operator = '=';
		$operand = array(array('col','id'), array('u', $id));
		$query = MCMS::Get_Instance()->Storage()->Get()->From('film_certificate')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Film_Certificate_Not_Found_Exception($operator, $operand);
		}
		$return = array();
		return $row = $result->fetch_object('Film_Certificate');
	}
	public static function Get_All(){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('film_certificate');
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Certificate')){
			$return[] = $row;
		}
		return $return;
	}
}