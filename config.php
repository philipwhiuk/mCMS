<?php

System::Get_Instance()->file('config/exception');

class Config {
	
	private $data;
	
	public function __construct($data){
		$this->data = (array) $data;
	}
	
	public function get($key){
		
		if(isset($this->data[$key])){
			return $this->data[$key];
		} else {
			throw new Config_Key_Not_Found_Exception($this, $key);
		}
		
	}
	
	// Does following check for sub.example.com:80/hi/me
	
	public static function Load(){
		
		$server = explode('.',$_SERVER['SERVER_NAME']);
		
		array_unshift($server, $_SERVER['SERVER_PORT']);
		
		$path = explode('/', trim(System::Get_Instance()->get_remote_path(),'/'));
		
		$exceptions = array();
		
		$k = array_merge($server, $path);
		
		for(; count($k) > 0; array_shift($k)){
			$l = $k;
			for(; count($l) > 0; array_pop($l)){
				try {
					return new Config(System::Get_Instance()->file('config/' . join('.', $l)));
				} catch(Exception $e){
					$exceptions[join('.', $k)] = $e;
				}
			}
		}
		
		try {
			return new Config(System::Get_Instance()->file('config/default'));
		} catch(Exception $e){
			$exceptions[join('.', $k)] = $e;
		}
		
		throw new Config_Not_Found_Exception($exceptions);
		
	}
	
}