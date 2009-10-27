<?php

define('CMS_AUTHENTICATION_UNSET', 0);
define('CMS_AUTHENTICATION_UNAVAILABLE', 1);
define('CMS_AUTHENTICATION_AVAILABLE', 2);

abstract class Authentication {
	private $id;
	private $module;
	private $priority;
	private $active;
	
	protected function __construct($data = array()){
		foreach($data as $k => $f){ $this->$k = $f; }
	}
	
	public function get_module(){
		return $this->module;
	}
	
	private static function Load(){
		if(!isset(System::Get_Instance()->authentication_plugins)){
			System::Get_Instance()->authentication_plugins = self::Get_Load();
		}
	}
	
	private static function Get_Load(){
		$query = System::Get_Instance()->database()->Select()->table('authentication')->where(
			'=', array(
				array('col', 'active'),
				array('u',1)
			)
		)->order(array('priority' => false));
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_assoc()){
			try {
				$row['module'] = Module::Get_ID($row['module']);
				$class = $row['module']->load_section('Authentication');
				$return[] = new $class($row);
			} catch(Exception $e){
				
			} 
		}
		
		return $return;
	}
	
	abstract protected function retrieve_user();
	abstract protected function authentication_available();
	abstract protected function authenticate_user($user);
	abstract protected function release_user();
	
	public static function Retrieve(){
		if(isset(System::Get_Instance()->authentication_user)){
			return System::Get_Instance()->authentication_user;
		}
		
		Authentication::Load();
		
		$exceptions = array();
		
		foreach(System::Get_Instance()->authentication_plugins as $auth){
			try {
				return $auth->retrieve_user();
			} catch(Exception $e){
				// Ignore exception
				$exceptions[] = $e;
			}
		}
		
		throw new Authentication_Retrieval_Exception($exceptions);
	}
	
	public static function Authenticable(){
		Authentication::Load();
		
		foreach(System::Get_Instance()->authentication_plugins as $auth){
			try {
				$case = $auth->authentication_available();
				switch($case){
					case CMS_AUTHENTICATION_AVAILABLE:
						return true;
						break;
					case CMS_AUTHENTICATION_UNAVAILABLE:
						return false;
						break;
				}
				
			} catch(Exception $e){
				// Ignore exception
			}
		}

		return false;
	}
	
	public static function Authenticate($user){
		Authentication::Load();
		
		$exceptions = array();
		
		foreach(System::Get_Instance()->authentication_plugins as $auth){
			try {
				if($auth->authentication_available()){
					return true;
				}
			} catch(Exception $e){
				// Ignore exception
				$exceptions[] = $e;
			}
		}
		
		throw new Authentication_Authenticate_Exception($exceptions);
		
	}
	
	public static function Release(){
		
		unset(System::Get_Instance()->authentication_user);
		
		foreach(System::Get_Instance()->authentication_plugins as $auth){
			try {
				$auth->release_user();
			} catch(Exception $e){
				// Ignore exception
			}
		}
		
	}
}