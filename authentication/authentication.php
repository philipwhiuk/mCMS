<?php

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
		)->order(array(array('priority', false)));
		
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
	
	public static function User(){
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
		
		throw new Authentication_User_Exception($exceptions);
	}
}