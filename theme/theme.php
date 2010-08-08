<?php


class Theme {
	
	private $id;
	private $name;
	private $directory;
	private $parent = 0;
	
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
		
		$query = System::Get_Instance()->database()->Select()->table('theme')->where($operator, $operand)->limit(1);
		
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

	public function parent(){
		if(!($this->parent instanceof Theme)){
			$this->parent = Theme::Get_By_ID($this->parent);
		}
		return $this->parent;
	}
	
	public function start($path, $data = array()){
		// Add data to path
		$spath = $path;
		$sdata = $data;
		try {
			$e = array_reverse(explode('/', $this->directory));
			foreach($e as $f){
				array_unshift($path, $f);
			}
			array_unshift($path, 'theme');
			$data['theme'] = $this;
			return Template::Start($path, $data);
		} catch(Exception $e){
			try {
				return $this->parent()->start($spath, $sdata);
			} catch(Exception $f){
				throw new Theme_Template_Not_Found_Exception($e, $f);
			}
		}
	}
	
}
