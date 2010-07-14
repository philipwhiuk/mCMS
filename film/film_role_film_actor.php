<?php

class Film_Role_Film_Actor {
	public function get_id() {
		return $this->id;
	}
	public function get_actor(){
		if(!($this->actor instanceof Actor)){
			$this->actor = Actor::Get_By_ID($this->actor);
		}
		return $this->actor;
	}

	public function get_film_role(){
		if(!($this->role instanceof Film_Role)){
			$this->role = Film_Role::Get_By_ID($this->role);
		}
		return $this->role;
	}
	public function get_film(){
		if(!($this->film instanceof Film)){
			$this->film = Film::Get_By_ID($this->film);
		}
		return $this->film;
	}
	public static function Get_By_Actor($actor) {
		if($actor instanceof Actor) {
			$actor = $actor->get_id();
		}
		$query = System::Get_Instance()	->database()
			->Select()
			->table('film_role_film_actor')
			->where('=', array(array('col','actor'), array('u', $actor)));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Role_Film_Actor')){
			$return[] = $row;
		}
		return $return;
	}
}
