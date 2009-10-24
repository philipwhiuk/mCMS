<?php

class HTML_Output extends Output {
	
	private $theme;
	
	public function __construct(){
		$this->theme = Theme::Load();
	}
	
	public static function Create(){
		
		return new HTML_Output();
		
	}
	
	public function render($data){
		$template = System::Get_Instance()->output()->start(array('main'));
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