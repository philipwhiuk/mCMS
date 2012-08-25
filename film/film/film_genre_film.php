<?php
class Film_Genre_Film {
	public function get_genre(){
		if(!($this->genre instanceof Film_Genre)){
			$this->genre = Film_Genre::Get_By_ID($this->genre);
		}
		return $this->genre;
	}
	public function get_film(){
		if(!($this->film instanceof Film)){
			$this->film = Film::Get_By_ID($this->film);
		}
		return $this->film;
	}
	public static function Get_By_Genre($genre) {
		if($genre instanceof Film_Genre) {
			$genre = $genre->get_id();
		}
		$query = MCMS::Get_Instance()->Storage()
			->Get()
			->From('film_genre_film')
			->where('=', array(array('col','genre'), array('u', $genre)));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Genre_Film')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Get_By_Film($film) {
		if($film instanceof Film) {
			$film = $film->get_id();
		}
		$query = MCMS::Get_Instance()->Storage()
			->Get()
			->From('film_genre_film')
			->where('=', array(array('col','film'), array('u', $film)));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Genre_Film')){
			$return[] = $row;
		}
		return $return;
	}
}