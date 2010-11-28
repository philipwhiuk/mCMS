<?php

// Represents a user being part of a group!

class Group_User {
	
	public static function Get_All($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('group_user')->where($operator, $operand);
		
		$result = $query->execute();
		
		$return = array();
		
		while($gu = $result->fetch_object('Group_User')){
			$return[] = $gu;
		}
		
		return $return;
		
	}
	
	public function get_group(){
		if(!($this->group instanceof Group)){
			$this->group = Group::Get_By_ID($this->group);
		}
		return $this->group;
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
		foreach($user->groups as $k => $gu){
			$return[] = $user->groups[$k]->get_group();
		}
		
		return $return;
	}
	
}
