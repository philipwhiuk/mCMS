<?php

define('CMS_PERM_NOT_SET',0);
define('CMS_PERM_DISALLOWED',1);
define('CMS_PERM_ALLOWED',2);

// Use three value


abstract class Permission {
	
	protected $id;
	protected $descriptor;
	protected $permission;
	
	public function get_permission(){
		return $this->permission;
	}
	
	abstract public static function Get_By_Check($descriptor, $object);
	
	public static function Check($descriptor, $permissions, $check_mode = null, $user = null){
		
		// Inital set up.
		
		$d = '';
		$descriptors = array();
		foreach($descriptor as $desc){
			$descriptors[] = $d . $desc;
			$d .= $desc . '/';
		}
		
		if(!isset($user)){
			$user = Authentication::Retrieve();
		}
		
		// First check super user permision.
		
		$super = CMS_PERM_NOT_SET;
		
		if(System::Get_Instance()->permission_group){
			$groups = Group::Get_By_User($user);

			foreach($groups as $group){
				try {
					$slocal = Permission_Group::Get_By_Check('',$group);
				} catch(Exception $e){
					$slocal = CMS_PERM_NOT_SET;
				}
				if($super == CMS_PERM_NOT_SET && $slocal == CMS_PERM_ALLOWED){
					$super = $slocal;
				} elseif($slocal == CMS_PERM_DISALLOWED){
					$super = CMS_PERM_DISALLOWED;
				} elseif($slocal != CMS_PERM_ALLOWED && $slocal != CMS_PERM_NOT_SET){
					throw new Permission_Invalid_Exception('',$slocal, $group);
				}
			} 
		}
		
		try {
			$slocal = Permission_User::Get_By_Check('',$user)->get_permission();
		} catch(Exception $e){
			$slocal = CMS_PERM_NOT_SET;
		}
		
		if($slocal == CMS_PERM_ALLOWED || $slocal == CMS_PERM_DISALLOWED){
			$super = $slocal;
		} elseif($slocal != CMS_PERM_NOT_SET){
			throw new Permission_Invalid_Exception('',$slocal, $user);
		}
		
		if($super == CMS_PERM_ALLOWED){
			foreach($permissions as $mode){
				$modes[$mode] = true;
			}
			return $modes;
		}
		
		foreach($permissions as $mode){
			$modes[] = CMS_PERM_NOT_SET;
		}
		foreach($descriptors as $desc){
			$dmodes = array();
			foreach($permissions as $mode){
				$dmodes[] = CMS_PERM_NOT_SET;
			}
			
			if(System::Get_Instance()->permission_group){
				foreach($groups as $group){
					try {
						$local = Permission_Group::Get_By_Check($desc, $group)->get_permission();
					} catch(Exception $e){
						$local = CMS_PERM_NOT_SET;
					}
					if($local < 0){
						throw new Permission_Invalid_Exception($desc,$slocal,$group);
					}
					$i = 0;
					while($local > 0){
						$mlocal = $local % 3;
						$local -= $mlocal;
						if($mlocal == CMS_PERM_DISALLOWED){
							// Disallowed propogates
							$dmodes[$i] = $mlocal;
						} elseif($mlocal == CMS_PERM_ALLOWED && $dmodes[$i] == CMS_PERM_NOT_SET){
							// Allow only if not already set.
							$dmodes[$i] = $mlocal;
						}
						$i ++;
					}
				}
			}
			try {
				$local = Permission_User::Get_By_Check($desc, $user)->get_permission();
			} catch(Exception $e){
				$local = CMS_PERM_NOT_SET;
			}
			
			if($local < 0){
				throw new Permission_Invalid_Exception($desc,$slocal,$user);
			}
			$i = 0;
			while($local > 0){
				$mlocal = $local % 3;
				$local -= $mlocal;
				$local = $local / 3;
				if($mlocal == CMS_PERM_DISALLOWED || $mlocal == CMS_PERM_ALLOWED){
					// User overrides
					$dmodes[$i] = $mlocal;
				}
				$i ++;
			}
			
			foreach($modes as $k => $mode){
				if($dmodes[$k] != CMS_PERM_NOT_SET){
					$modes[$k] = $dmodes[$k];
				}
			}
			
		}

		$result = array();
		
		foreach($permissions as $k => $mode){
			$result[$mode] = ($modes[$k] == CMS_PERM_ALLOWED);
		}
		
		if(isset($check_mode)){
			// Check for Mode
			if(!$result[$check_mode]){
				throw new Permission_Unauthorised_Exception($descriptor, $result, $check_mode);
			}
		}
		
		return $result;
	} 
	
}

