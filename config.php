<?php

MCMS::Get_Instance()->file('config/exception');
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
		
		$system = MCMS::Get_Instance();

		$parse = parse_url($system->remote_path());

		if(!isset($parse['port']) && isset($_SERVER['SERVER_PORT'])){ 
			$parse['port'] = $_SERVER['SERVER_PORT']; 
		}

		$server = explode('.', $parse['host']);

		array_unshift($server, $parse['port'], $parse['scheme']);

		$parse['path'] = trim($parse['path'], '/');
		
		if(strlen($parse['path']) != 0){
			$path = explode('/', $parse['path']);
		} else {
			$path = array();
		}

		$exceptions = array();
		
		$k = array_merge($server, $path);

		for(; count($k) > 0; array_shift($k)){
			$l = $k;
			for(; count($l) > 0; array_pop($l)){
				try {
					return new Config($system->file('config/' . join('.', $l), false));
				} catch(Exception $e){
					$exceptions[join('.', $l)] = $e;
				}
			}
		}
		
		try {
			return new Config($system->file('config/default', false));
		} catch(Exception $e){
			$exceptions[join('.', $k)] = $e;
		}
		
		throw new Config_Not_Found_Exception($exceptions);
		
	}
	
}
