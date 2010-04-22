<?php
class Film_Trailer {
	private $id;
	private $video;
	private $film;
	public function get_video() {
		if(!$this->video instanceof Video) {
			$this->video = Video::Get_By_ID($this->video);
		}
		return $this->video;
	}
	public function get_film() {
		if(!$this->film instanceof Film) {
			$this->film = Film::Get_By_ID($this->film);
		}
		return $this->film;
	}
	public static function Get_By_Film_ID($film, $trailer) {
	
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