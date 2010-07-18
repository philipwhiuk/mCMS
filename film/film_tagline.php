<?php
class Film_Tagline {
	private $id;
	private $text;
	public function id() {
		return $this->id;
	}
	public function text() {
		return $this->text;
	}
	public static function Get_By_Film($film) {
		if($film instanceof Film) {
			$film = $film->get_id();
		}
		$operator = '=';
		$operand = array(array('col','film'), array('u', $film));
		$query = System::Get_Instance()->database()->Select()->table('film_tagline')->where($operator, $operand);
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Tagline')){
			$return[] = $row;
		}
		return $return;
	}
}