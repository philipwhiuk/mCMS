<?php
abstract class Profile_Field_Impl {

	protected $parent;

	public function __construct($parent){
		$this->parent = $parent;
	}
	abstract function profile($profile);

	/** Profile_Field_Impl is the base class for all Profile Field types **/
	static function Get_By_Type_ID($type,$field) {
		try {
			$profile_field = call_user_func(array('Profile_Field_'.$type,'Get_By_ID'),$field);
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