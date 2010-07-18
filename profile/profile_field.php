<?php
abstract class Profile_Field {
	/** Profile Field is the base class for all Profile Field types **/
	static function Get_By_Type_ID($this->type,$this->field) {
		try {
			$profile_field = call_user_func(array('Profile_Field_'.$this->type,$this->field),'Get_By_ID');
			if(!$profile_field) {
				throw new Profile_Field_Type_Not_Found_Exception();
			}
			else {
				return $profile_field;
			}
		}
		catch(Exception $e) {
			throw new Profile_Field_Not_Found_Exception($e);	
		}
	}
}