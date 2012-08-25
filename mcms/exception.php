<?php
class MCMS_Exception extends Exception {

	protected $data;
	protected $message;
	protected $level;
	
	public function  __construct(){
		$system = MCMS::Get_Instance();
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
	public function data() {
		return $this->data;
	}
}
class MCMS_Load_Exception extends MCMS_Exception {

	public function message(){
		return "System Failed To Load: " . $this->data[0]->message();
	}

	public function dump(){
		return "System Load Failiure. \r\n\t" . join("\n\t",explode("\n",$this->data[0]->dump()));
	}

}
class MCMS_Not_Installed_Exception extends MCMS_Exception {

	protected $level = MCMS::dump_warning;

	public function dump(){ 
		return $this->message() . "\r\n\t" . join("\r\n\t",explode("\r\n",$this->data[0]->dump()));
	}
		

	public function message(){
		return "MCMS Not Installed.";
	}

}
class MCMS_Install_Exception extends MCMS_Exception {

	public function dump(){ 
		$string = $this->message();
		foreach($this->data[0] as $e){
			$string .= "\r\n\t" . join("\r\n\t",explode("\r\n",$e->dump()));
		}
		return $string;
	}

	public function message(){
		return "MCMS Install Failed.";
	}	

}
class MCMS_File_Not_Found_Exception extends MCMS_Exception {
	protected $level = MCMS::dump_notice;
	
	public function dump(){ return $this->message(); }
	public function message(){
		return 'File [' . $this->data[0] . '] not found.';
	}
}

class MCMS_Resource_Exception extends MCMS_Exception {
	protected $level = MCMS::dump_error;

	public function message(){
		return get_class($this) . ' ' . (is_array($this->data[0]) ? join('/', $this->data[0]) : $this->data[0]);
	}
}

class MCMS_Load_Resource_Exception extends MCMS_Exception {
	protected $level = MCMS::dump_error;	
}