<?php
class Profile_Field {	
	/** Profile_Field stores a list of all fields and their types **/
	private $id;
	private $content;
	private $type;
	private $field;
	
	public function id() {
		return $this->id;
	}
	public function content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public function type() {
		return $this->type;
	}
	
	public function field() {
		if(!($this->field instanceof Profile_Field_Impl)){
			$class = $this->type;
			// var_dump(System::Get_Instance()->profile['fields']);
			foreach(System::Get_Instance()->profile['fields'] as $field_type) {
				if($field_type['class'] == $class) {
					$field_type['module']->file($field_type['file']);
					if(!class_exists($class) || !is_subclass_of($class, 'Profile_Field_Impl')){
						throw new Profile_Field_Invalid_Exception($field_type);
					}
					else {
						$this->field = $class::Get_By_ID($this->field,$this);
						return $this->field;
					}
				}
				else {
					exit('error');
				}
			}
			throw new Profile_Field_Unavailable_Exception($class);
		}
		return $this->field;
	}
	public static function Get_By_Label($label) {
		return self::Get_One('=', array(array('col','label'), array('s', $label)));
	}
	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('profile_field')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Profile_Field_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Profile_Field');
	}
	public static function Get_All($limit = null, $skip = null){
		$query = System::Get_Instance()->database()->Select()->table('profile_field');
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Profile_Field')){
			$return[] = $row;
		}
		return $return;
	}
	public static function Register($class, $file, $module){
		System::Get_Instance()->profile['fields'][] = array('class' => $class, 'file' => $file, 'module' => $module);
	}
}