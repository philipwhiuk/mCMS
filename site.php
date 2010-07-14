<?php

// Load exceptions

System::Get_Instance()->files('site/exception');

class Site {
	
	private $id;
	private $name;
	
	private function __construct(){
		
	}
	
	public function get($key){
		if(isset($this->$key)){
			return $this->$key;
		}
		throw new Site_Key_Not_Found_Exception($key);
	}
	
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('site')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Site_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('Site');
		
		return $site;
		
	}
	
	public static function Load(){
		
		
		try {
			$config = System::Get_Instance()->config()->get('site');
		} catch(Exception $e){
			throw new Site_Configuration_Exception($e);
		}
		
		return Site::Get_By_ID($config);
		
	}
	
	
}
