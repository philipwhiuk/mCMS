<?php


class Theme {
	
	private $id;
	private $name;
	private $directory;
	private $parent = 0;
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('theme');
		return $query->execute();

	}
	public static function Load(){
		try {
			$site = MCMS::Get_Instance()->site()->get('theme');
			
			return Theme::Get_By_ID($site);
		} catch(Exception $e){
			try {
				$config = MCMS::Get_Instance()->config()->get('theme');			
				return Theme::Get_By_ID($config);
			} catch(Exception $f){
				throw new Theme_Unavailable_Exception($e, $f);
			}
		}
	}
	public static function Get_All($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('theme')->order(array('name' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Theme')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_One($operator, $operand){
		
		$query = MCMS::Get_Instance()->storage()->Get()->From('theme')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Theme_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('Theme');
		
		return $site;
		
	}
	
	public function url($path, $internal = false){
		return MCMS::Get_Instance()->url('theme/' . $this->directory. '/' . $path, array(), $internal);
	}

	public function parent(){
		if(!($this->parent instanceof Theme) && $this->parent != MCMS_TOP_LEVEL_THEME){
			$this->parent = Theme::Get_By_ID($this->parent);
		}
		else if(!($this->parent instanceof Theme) && $this->parent == MCMS_TOP_LEVEL_THEME) {
			return null;
		}
		return $this->parent;
	}
	public function id() {
		return $this->id;
	}
	public function name() {
		return $this->name;
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
				if($this->parent() != null) {
					return $this->parent()->start($spath, $sdata);				
				}
				else {
					throw new Theme_Top_Level_Theme_Template_Not_Found_Exception($e,$f);
				}
			} catch(Exception $f){
				throw new Theme_Template_Not_Found_Exception($e, $f);
			}
		}
	}
	
}
