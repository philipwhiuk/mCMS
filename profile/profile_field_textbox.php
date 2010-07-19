<?php
class Profile_Field_Textbox extends Profile_Field_Impl{
	/** Profile Textbox is the implementation of a Textbox for the Profile **/
	private $id;
	private $default;
	private $profiles;
	public function profiles() {
		if(!is_array($this->profiles)) {
			Module::Get('profile')->file('profile_field_textbox_profile');
			$this->profiles = Profile_Field_Textbox_Profile::Get_By_Field($this->id);
		}
		return $this->profiles;
	}
	public function profile($profile) {
		Module::Get('profile')->file('profile_field_textbox_profile');
		if($profile instanceof Profile) {
			$profile = $profile->id();
		}
		$this->profiles();
		if(isset($this->profiles[$profile])) {
			return $this->profiles[$profile];
		}
		else return new Profile_Field_Textbox_Profile($this,$this->default,$profile);
	}
	public static function Get_By_ID($id,$parent) {
		return self::Get_One('=', array(array('col','id'), array('u', $id)),array($parent));
	}
	public static function Get_One($operator, $operand,$construct_params){
		$query = System::Get_Instance()->database()->Select()->table('profile_field_textbox')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Profile_Field_Textbox_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Profile_Field_Textbox',$construct_params);
	}
	public function display_view($profile) {
		$p = $this->profile($profile);
		$template = System::Get_Instance()->output()->start(array('profile','field','textbox','view'));
		$template->data = $p->content()->get_body();
		return $template;
	}
}