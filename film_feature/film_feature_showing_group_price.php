<?php
class Film_Feature_Showing_Group_Price {
	private $group;
	private $price;
	private $showing;
	public function get_group() {
		if(!$this->group instanceof Group) {
			$this->group = Group::Get_By_ID($this->group);
		}
		return $this->group;	
	}
	public function get_price() {
		return $this->price;
	}
	public static function Get_By_Showing($showing) { 
		if($showing instanceof Film_Feature_Showing) {
			$showing = $showing->get_id();
		}
		$query = System::Get_Instance()	->database()
			->Select()
			->table('film_feature_showing_group_price')
			->where('=', array(array('col','showing'), array('u', $showing)));
		$result = $query->execute();
		while($row = $result->fetch_object('Film_Feature_Showing_Group_Price')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Get_By_Showing_Group($showing,$group) {
		if($showing instanceof Film_Feature_Showing) {
			$showing = $showing->get_id();
		}
		if($group instanceof Group) {
			$group = $group->get_id();
		}
		$query = System::Get_Instance()->database()
			->Select()
			->table('film_feature_showing_group_price')
			->where('AND',
					array(
						array('=', array(array('col','showing'),array('u', $showing))),
						array('=', array(array('col','group'),array('u', $group)))
					)
				)
			->limit(1);
		$result = $query->execute();
		if(!
		   ($row = $result->fetch_object('Film_Feature_Showing_Group_Price'))
		){
			throw new Film_Feature_Showing_Group_Not_Found_Exception();
		}
		return $row;		
	}
}