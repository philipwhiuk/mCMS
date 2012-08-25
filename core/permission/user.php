<?php

class Permission_User extends Permission {

	private $user;
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('permission_user')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Permission_User_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Permission_User');
		
	}
	
	public static function Get_By_Check($descriptor, $user){
		if($user instanceof User){
			$user = $user->get_id();
		}
		
		if(!isset(MCMS::Get_Instance()->permission_user_cache[$user][$descriptor])){
			$permission = self::Get_One('AND', array(
				array('=',array(
					array('col','descriptor'), 
					array('s', $descriptor)
				)),
				array('=',array(
					array('col','user'), 
					array('s', $user)
				))
			));
			
			MCMS::Get_Instance()->permission_user_cache[$user][$descriptor] = $permission;
		}
		
		return MCMS::Get_Instance()->permission_user_cache[$user][$descriptor];
		
	}
	
}
