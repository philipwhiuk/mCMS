<?php
class Film_Film_Feature_Impl extends Film_Feature_Impl {
	private $id;
	private $feature;
	private $film;
	public function get_id() {
		return $this->id;
	}
	public function get_feature(){
		if(!($this->feature instanceof Film_Feature)){
			$this->feature = Film_Feature::Get_By_ID($this->feature);
		}
		return $this->feature;
	}
	public function get_film(){
		if(!($this->film instanceof Film)){
			$this->film = Film::Get_By_ID($this->film);
		}
		return $this->film;
	}	
	public static function Get_By_Film_Feature($feature) {
		if($feature instanceof Film_Feature) {
			$feature = $feature->get_id();
		}
		$query = MCMS::Get_Instance()	->Storage()
			->Get()
			->From('film_feature_film')
			->where('=', array(array('col','feature'), array('u', $feature)));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Film_Feature_Impl')){
			$return[] = $row;
		}
		return $return;
	}
}