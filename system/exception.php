<?php

class CMS_Exception extends Exception {

	protected $data;
	protected $message;
	protected $level;
	
	public function  __construct(){
		$system = System::Get_Instance();
		if(!isset($this->level)){ $this->level = $system->debug_default_level; }
		parent::__construct();
		$this->data = func_get_args();
		$system->dump($this->level, $this, true);
	}

	public function dump(){
		return get_class($this) . "\r\n" . print_r($this->data, true);
	}

	public function message(){
		return get_class($this);
	}

}

class System_Exception extends CMS_Exception {}
class System_Load_Exception extends System_Exception {

	public function message(){
		return "System Failed To Load: " . $this->data[0]->message();
	}

	public function dump(){
		return "System Load Failiure. \r\n\t" . join("\n\t",explode("\n",$this->data[0]->dump()));
	}

}
class System_Not_Installed_Exception extends System_Exception {

	protected $level = System::dump_warning;

	public function dump(){ 
		return $this->message() . "\r\n\t" . join("\r\n\t",explode("\r\n",$this->data[0]->dump()));
	}
		

	public function message(){
		return "System Not Installed.";
	}

}
class System_Install_Exception extends System_Exception {

	public function dump(){ 
		$string = $this->message();
		foreach($this->data[0] as $e){
			$string .= "\r\n\t" . join("\r\n\t",explode("\r\n",$e->dump()));
		}
		return $string;
	}

	public function message(){
		return "System Install Failed.";
	}	

}
class System_File_Not_Found_Exception extends System_Exception {
	protected $level = System::dump_notice;
	
	public function dump(){ return $this->message(); }
	public function message(){
		return 'File [' . $this->data[0] . '] not found.';
	}
}

class System_Resource_Exception extends System_Exception {
	protected $level = System::dump_error;

	public function message(){
		return get_class($this) . ' ' . (is_array($this->data[0]) ? join('/', $this->data[0]) : $this->data[0]);
	}
}

class System_Load_Resource_Exception extends System_Exception {
	protected $level = System::dump_error;	
}
