<?php

class HTML_Output extends Output {
	
	private $theme;
	private $head = array();
	
	public function __construct(){
		$this->theme = Theme::Load();
	}
	
	public static function Create(){
		
		return new HTML_Output();
		
	}
	
	public function head($key, $data){
		$this->head[$key] = $data;
	}
	
	public function render($data){
		$template = System::Get_Instance()->output()->start(array('main'));
		$template->head = $this->head;
		$template->main = $data;
		$template->display();
	}
	
	public function start($path, $data = array()){
		// Add data to path
		array_unshift($path, 'html');
		$data['html'] = $this;
		return $this->theme->start($path, $data);
	}
	
}