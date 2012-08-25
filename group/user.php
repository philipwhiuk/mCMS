<?php

// Represents a user being part of a group!

class Group_User {
	
	public static function Get_All($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('group_user')->where($operator, $operand);
		
		$result = $query->execute();
		
		$return = array();
		
		while($gu = $result->fetch_object('Group_User')){
			$return[] = $gu;
		}
		
		return $return;
		
	}
	
	public static function Get_By_User($user){
		if(!($user instanceof User)){
			$user = User::Get_By_ID($user);
		}
		
		if(!isset($user->groups)){
			$user->groups = Group_User::Get_All('=', array(
				array('col','user'),
				array('u',$user->get_id())
			));
		}		
		
		$return = array();
		foreach($user->groups as $gu){
			$return[] = $user->groups->get_group();
		}
		
		return $return;
	}
	
}
