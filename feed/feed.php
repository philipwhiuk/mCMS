<?php

class Feed {

	public function __construct($resource){
		$this->resource = $resource;

		$class = $resource->get_module()->load_section('Feed_Main');
		$this->main = call_user_func(array($class,'Load'), $this);
		
		if(!($this->main instanceof Feed_Main)){
			throw new Feed_Main_Invalid_Exception($class, $this);
		}

	}

	public function resource(){
		return $this->resource;
	}
	
	public function url($url){
		return MCMS::Get_Instance()->url($url);
	}

	public function display(){
		return $this->main->display();
	}

	public static function Load($resource){
		try {
			return new Feed($resource);
		} catch(Exception $e){
			throw new Feed_Fatal_Exception($e);
		}
	}



}
