<?php
class Film_Festival_Event_Impl extends Event_Impl {
	private $id;
	private $film_festival;
	private $event;
	public function get_id() {
		return $this->id;
	}
	public function get_festival(){
		if(!($this->film_festival instanceof Film_Festival)){
			$this->film_festival = Film_Festival::Get_By_ID($this->film_festival);
		}
		return $this->film_festival;
	}
	static function Get_By_Event($event) {
		if($event instanceof Event) {
			$event = $event->get_id();
		}
		$query = MCMS::Get_Instance()	->Storage()
			->Get()
			->From('film_festival_event')
			->where('=', array(array('col','event'), array('u', $event)));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Festival_Event_Impl')){
			$return[$row->get_id()] = $row;
		}
		return $return;
	}
}