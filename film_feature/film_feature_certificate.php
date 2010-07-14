<?php
class Film_Feature_Film_Certificate extends Film_Certificate {
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
		$query = System::Get_Instance()->database()->Select()->table('film_certificate')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		$return = array();
		return $row = $result->fetch_object('Film_Film_Certificate');
	}
	public static function Get_By_Film($film) {
		if($film instanceof Film) {
			$film = $film->get_id();
		}
		$operator = '=';
		$operand = array(array('col','film'), array('u', $film));
		$query = System::Get_Instance()->database()->Select()->table('film_trailer')->where($operator, $operand);
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Trailer')){
			$return[] = $row;
		}
		return $return;
	}
}