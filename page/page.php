<?php

class Page {
	
	private $resource;
	
	private $main;
	private $blocks;
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('page'));
		$template->main = $this->main->display();
		$template->blocks = array();
		foreach($this->blocks as $block){
			$template->blocks[$block->get_layout()][$block->get_order()] = $block->display();
		}
		foreach($template->blocks as $layout => $blocks){
			ksort($template->blocks[$layout]);
		}
		return $template;
	}
	
	public function resource(){
		return $this->resource;
	}
	
	public function url($url){
		return System::Get_Instance()->url($url);
	}
	
	public function __construct($resource){
		$this->resource = $resource;
		$class = $resource->get_module()->load_section('Page_Main');
		$this->main = call_user_func(array($class, 'Load'), $this);
		
		if(!($this->main instanceof Page_Main)){
			throw new Page_Main_Invalid_Exception($class, $this);
		}
		
		$this->blocks = Page_Block::Load($this->resource()->get_id());
	}
	
	public static function Load($path){
		if($path == ''){
			$path = 'home';
		}
		$exceptions = array();
		$resources = Resource::Get_By_Paths(array($path,'error'));
		foreach($resources as $resource){
			try {
				return new Page($resource);
			} catch(Exception $e){
				$exceptions[] = $e;
			}
		}
		
		// Darn, critical error. What do we do now?
		
		// TODO: Implement last gasp system
		
		throw new Page_Fatal_Exception($exceptions);
	}
	
	
}