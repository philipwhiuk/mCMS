<?php

MCMS::Get_Instance()->files('site/exception');

/**
 * Site information.
 */ 
class Site {
    /**
	 * Fetch a site with the given ID.
	 */
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	/**
	 * Fetch one site.
	 */
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('site')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Site_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('Site');
		
		return $site;
		
	}
	/**
	 * Load the site as set in the configuration.
	 */
	public static function Load(){
		
		
		try {
			$config = MCMS::Get_Instance()->config()->get('site');
		} catch(Exception $e){
			throw new Site_Configuration_Exception($e);
		}
		
		return Site::Get_By_ID($config);
		
	}	
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
	

}