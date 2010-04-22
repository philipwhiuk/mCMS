<?php
class Film_Lead {
	private $id;
	private $actor;
	private $film;
	public function get_id() {
		return $this->id;
	}
	public function get_film(){
		if(!($this->film instanceof Film)){
			$this->film = Film::Get_By_ID($this->film);
		}
		return $this->film;
	}
	public function get_actor(){
		if(!($this->actor instanceof Actor)){
			$this->actor = Actor::Get_By_ID($this->actor);
		}
		return $this->actor;
	}
	public static function Get_By_Film($film) {
		if($film instanceof Film) {
			$film = $film->get_id();
		}
		$query = System::Get_Instance()	->database()
			->Select()
			->table('film_lead')
			->where('=', array(array('col','film'), array('u', $film)));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Lead')){
			$return[] = $row;
		}
		return $return;
	}
}