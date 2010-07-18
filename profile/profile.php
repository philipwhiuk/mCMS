<?php
class Profile {	
	/** Profile stores a list of all fields and their types **/
	private $id;
	private $content;
	private $type;
	private $field;
	public id() {
		return $this->id;
	}
	public content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public type() {
		return $this->type;
	}
	public field() {
		if(!$this->field instanceof Profile_Field) {
			$this->field = Profile_Field::Get_By_Type_ID($this->type,$this->field);	
		}
	}
}