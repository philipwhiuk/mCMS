<?php

class Group {
	
	private $id;
	private $name;

	public static function Get_By_User($user){
		return Group_User::Get_By_User($user);
	}
	
}