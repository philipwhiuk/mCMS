<?php
class Film_Feature_Event_Impl extends Event_Impl {
	private $id;
	private $feature;
	private $event;
	public function get_id() {
		return $this->id;
	}
	public function feature(){
		if(!($this->feature instanceof Film_Feature)){
			$this->feature = Film_Feature::Get_By_ID($this->feature);
		}
		return $this->feature;
	}
	static function Get_By_Event($event) {
		if($event instanceof Event) {
			$event = $event->get_id();
		}
		$query = System::Get_Instance()	->database()
			->Select()
			->table('film_feature_event')
			->where('=', array(array('col','event'), array('u', $event)));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Feature_Event_Impl')){
			$return[$row->get_id()] = $row;
		}
		return $return;
	}
}