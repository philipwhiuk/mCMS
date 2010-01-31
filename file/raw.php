<?php

class File_Raw extends Raw {
	
	private $file;
	private $download = false;
	
	protected function __construct($resource, $file){
		parent::__construct($resource);
		$this->file = $file;
		Permission::Check(array('file',$file->id()), array('view','edit','upload','delete'),'view');
		if($resource->get_argument() == 'download'){
			$this->download = true;
			$resource->consume_argument();
		}
	}
	
	public function display(){
		return $this;
	}
	
	public function output(){
		if($this->download){
			header('Content-Disposition: attachment; filename="' . $this->file->name() . '"');
		} else {
			header('Content-Disposition: filename="' . $this->file->name() . '"');
		}
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
