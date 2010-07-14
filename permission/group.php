<?php

class Permission_Group extends Permission {

	private $group;
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('permission_group')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Permission_Group_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Permission_Group');
		
	}
	
	public static function Get_By_Check($descriptor, $group){
		if($group instanceof Group){
			$group = $group->get_id();
		}
		
		if(!isset(System::Get_Instance()->permission_user_cache[$group][$descriptor])){
			$permission = self::Get_One('AND', array(
				array('=',array(
					array('col','descriptor'), 
					array('s', $descriptor)
				)),
				array('=',array(
					array('col','group'), 
					array('s', $group)
				))
			));
			
			System::Get_Instance()->permission_group_cache[$group][$descriptor] = $permission;
		}
		
		return System::Get_Instance()->permission_group_cache[$group][$descriptor];
		
	}
	
}
