<?php

class File {
	
	private $id;
	private $name;
	private $path;
	private $mime;
	private $size;
	private $time;
	
	private function __construct(){}
	
	public function id(){
		return $this->id;
	}
	
	public function name(){
		return $this->name;
	}
	
	public function location(){
		return System::Get_Instance()->local_path($this->path);
	}
	
	public function url(){
		$module = Module::Get('file');
		$resource = Resource::Get_By_Argument($module, $this->id);
		return System::Get_Instance()->url($resource->url(), array('output' => 'raw'));
	}
	
	public function size(){
		return $this->size;
	}
	
	public function mime(){
		return $this->mime;
	}

	static public function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	
	public static function Get_All(){
		$query = System::Get_Instance()->database()->Select()->table('files');
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('File')){
			$return[] = $row;
		}
		
		return $return;
	}
	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('files')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new File_Not_Found_Exception($operator, $operand);
		}
		
		$site = $result->fetch_object('File');
		
		return $site;
		
	}
	
}