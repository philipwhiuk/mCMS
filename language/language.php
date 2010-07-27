<?php

class Language {
	
	private $id;
	private $name;
	private $location;
	private $locate;
	
	private $data = array();
	
	public function __construct(){
	}
	public function id() {
		return $this->id;
	}
	public function get_translation($key){
		$k =& $this->data;
		foreach($key as $v){
			if(!isset($k[$v])){
				throw new Language_Translation_Not_Found_Exception($key, false);
			}
			$k =& $k[$v];
		}
		if(is_array($k) && isset($k[0])){
			return $k[0];
		}
		return $k;
	}
	
	public function file($file, $once = true){
		try {
			return System::Get_Instance()->file('language/' . $this->location . '/' . $file, $once);
		} catch(Exception $e){
			throw new Language_File_Not_Found_Exception($e);
		}
	}
	
	public function merge($data){
		$this->data = array_merge_recursive($this->data, $data);
	}
	
	public function get($module, $key){
		
		// files to search
		
		// module/language/translation
		try {
			return $this->get_translation($key);
		} catch (Exception $e){
			// We need to get the translation!
		}
		
		$search[] = '';
		
		foreach($key as $v => $k){
			$s[] = $k;
			$search[] = '/' . join('/', $s);
		}
		
		$search = array_reverse($search);
		
		$exceptions = array();
		
		foreach($search as $k => $v){
			try {
				$this->merge($this->file($module->get_directory() . $v, false));
			} catch(Exception $e){
				$execptions[] = $e;
			}
			try { 
				$this->merge($module->file($this->location . '/' . $v, false));
			} catch(Exception $e){
				$execptions[] = $e;
			}
			try {
				return $this->get_translation($key);
			} catch(Exception $e){
				
			}
		}
		throw new Language_Translation_Not_Found_Exception($key, true);
	}
	
	public static function Retrieve(){
		if(isset(System::Get_Instance()->language)){
			return System::Get_Instance()->language;
		}
		try {
			Module::Available('authentication');
			Module::Available('user');
			$user = Authentication::Retrieve()->get('language');
			return Language::Get_By_ID($user);
		} catch(Exception $d){
			try {
				$site = System::Get_Instance()->site()->get('language');
				
				return Language::Get_By_ID($site);
			} catch(Exception $e){
				try {
					$config = System::Get_Instance()->config()->get('language');			
					return Language::Get_By_ID($config);
				} catch(Exception $f){
					throw new Language_Unavailable_Exception($d, $e, $f);
				}
			}
		}
	}
	
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('language')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Language_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('Language');
		
		return $site;
		
	}
	
}

