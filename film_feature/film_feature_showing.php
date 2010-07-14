<?php
class Film_Feature_Showing {
	private $id;
	private $datetime;
	public $feature;
	
	function get_id() {
		return $this->id;
	}
	function get_datetime() {
		return $this->datetime;
	}
	function feature_id() {
		if($this->feature instanceof Film_Feature) {
			return $this->feature->get_id();
		}
		return $this->feature;
	}
	function get_feature() {
		if(!$this->feature instanceof Film_Feature) {
			$this->feature = Film_Feature::Get_By_ID($this->feature);
		}
		return $this->feature;
	}
	function get_group_prices() {
		if(!isset($this->group_prices)) {
			$this->group_prices = Film_Feature_Showing_Group_Price::Get_By_Showing($this->id);
		}
		return $this->group_prices;
	}
	static function Get_By_Film_Feature($feature) {
		if($feature instanceof Film_Feature) {
			$feature = $feature->get_id();
		}
		$query = System::Get_Instance()->database()
			->Select()
			->table('film_feature_showing')
			->where('=', array(array('col','feature'), array('u', $feature)))
			->order(array('datetime' => true));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Feature_Showing')){
			$return[] = $row;
		}
		return $return;
	}
	static function Get_By_ID($id) {
		$query = System::Get_Instance()->database()
			->Select()
			->table('film_feature_showing')
			->where('=', array(array('col','id'), array('u', $id)))
			->order(array('datetime' => true));
		$result = $query->execute();
		$row = $result->fetch_object('Film_Feature_Showing');
		return $row;
	}
	static function Get_ComingSoon($number) {
		$query = System::Get_Instance()->database()
			->Select()
			->table('film_feature_showing')
			->where('>', array(array('col','datetime'), array('u', time())))
			->order(array('datetime' => true))
			->limit($number);
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Feature_Showing')){
			$return[] = $row;
		}
		return $return;	
	}
	static function Get_Period($first,$last) {
		$query = System::Get_Instance()->database()
			->Select()
			->table('film_feature_showing')
->where(
	'AND',
	array(
		array(
			'>',
			array(
				array(
					'col',
					'datetime'
				),
				array(
					'u',
					$first
				)
			)
		),
		array(
			'<',
			array(
				array(
					'col',
					'datetime'
				),
				array(
					'u',
					$last
				)
			)
		)
	)
)
			->order(array('datetime' => true));
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film_Feature_Showing')){
			$return[] = $row;
		}
		return $return;
	}
}