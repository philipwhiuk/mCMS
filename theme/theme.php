<?php


class Theme {
	
	private $id;
	private $name;
	private $directory;
	
	public static function Load(){
		try {
			$site = System::Get_Instance()->site()->get('theme');
			
			return Theme::Get_By_ID($site);
		} catch(Exception $e){
			try {
				$config = System::Get_Instance()->config()->get('theme');			
				return Theme::Get_By_ID($config);
			} catch(Exception $f){
				throw new Theme_Unavailable_Exception($e, $f);
			}
		}
	}
	
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('themes')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Theme_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('Theme');
		
		return $site;
		
	}
	
	public function url($path, $internal = false){
		return System::Get_Instance()->url('theme/' . $this->directory . '/' . $path, array(), $internal);
	}
	
	public function start($path, $data = array()){
		// Add data to path
		array_unshift($path, 'theme', $this->directory);
		$data['theme'] = $this;
		return Template::Start($path, $data);
	}
	
}