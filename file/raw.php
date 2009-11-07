<?php

class File_Raw extends Raw {
	
	private $file;
	
	protected function __construct($resource, $file){
		parent::__construct($resource);
		$this->file = $file;
		Permission::Check(array('file',$file->id()), array('view','edit','upload','delete'),'view');
	}
	
	public function display(){
		return $this;
	}
	
	public function output(){
		return file_get_contents($this->file->location());
	}
	
	public function mimetype(){
		return $this->file->mime();
	}
	
	public static function Load($resource){
		
		$arg = $resource->get_argument();
		
		if(is_numeric($arg)){
			$file = File::Get_By_ID((int) $arg);
			$resource->consume_argument();
			return new File_Raw($resource, $file);
		}
		
	}
	
	
	
}