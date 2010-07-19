<?php
class Profile {
	private $id;
	private $user;
	public function id() {
		return $this->id;	
	}
	public function user() {
		if(!$this->user instanceof User) {
			$this->user = User::Get_By_ID($this->user);
		}
		return $this->user;
	}
	public function field($label) {
		$field = Profile_Field::Get_By_Label($label);
		return $field;
	}
	public function fields() {
		if(!isset($this->fields)) {
			$fields = Profile_Field::Get_All();
			foreach($fields as $field) {
				$this->fields[] = $field;
			}
		}
		return $this->fields;
	}	
	public function Get_All() {
	}
	public function Get_By_ID($id) {
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('profile')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Profile_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Profile');
		
	}
}
	