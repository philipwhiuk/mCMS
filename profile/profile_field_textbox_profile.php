<?php
class Profile_Field_Textbox_Profile {
	/** Profile Textbox User is the storage of a user's data for a textbox field for the Profile **/
	private $textbox;
	private $profile;
	private $content;
	public function __construct($textbox=null,$content=null,$profile=null) {
		if(isset($textbox)) {
			$this->textbox = $textbox;
		}
		if(isset($content)) {
			$this->content = $content;
		}
		if(isset($profile)) {
			$this->profile = $profile;
		}
	}
	public function content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_By_Field($field){
		$query = System::Get_Instance()->database()->Select()->table('profile_field_textbox_profile')->where('=', array(array('col','textbox'), array('u', $field)));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Profile_Field_Textbox_Profile')){
			$return[$row->profile] = $row;
		}
		return $return;
	}	
	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('profile_field_textbox_profile')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Profile_Field_Textbox_Profile_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Profile_Field_Textbox_Profile');
		
	}
}