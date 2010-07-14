<?php
	class Film_Feature_Film_Festival_Impl extends Film_Festival_Impl {
		private $id;
		private $festival;
		private $feature;
		public function get_id() {
			return $this->id;
		}
		public function get_feature() {
			if(!($this->feature instanceof Film_Feature)){
				$this->feature = Film_Feature::Get_By_ID($this->feature);
			}
			return $this->feature;
		}
		public static function Get_By_Film_Festival($film_festival) {
			if($film_festival instanceof Film_Festival) {
				$film_festival = $film_festival->get_id();
			}
			$query = System::Get_Instance()	->database()
				->Select()
				->table('film_festival_feature')
				->where('=', array(array('col','festival'), array('u', $film_festival)));
			$result = $query->execute();
			$return = array();
			while($row = $result->fetch_object('Film_Feature_Film_Festival_Impl')){
				$return[$row->get_id()] = $row;
			}
			return $return;
		}
	}
?>