<?php

class RSS_Output extends Output {
	
	public function __construct(){
	
	}

	public function start($path, $data = array()){
		array_unshift($path, 'rss');
		$data['rss'] = $this;
		return Template::Start($path, $data);
	}
	
	public static function Create(){
		return new RSS_Output();
	}
	
	public function render($data){
		header('Content-type: application/rss+xml');
		$template = $this->start(array('main'));
		$template->main = $data;
		$template->display();
	}
	
	public function logic($path){		
		return Feed::Load($path);
	}
	
}
