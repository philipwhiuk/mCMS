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
	
	public function __construct($resource){
		$this->resource = $resource;
		$class = $resource->get_module()->load_section('Page_Main');
		$this->main = call_user_func(array($class, 'Load'), $this);
		
		if(!($this->main instanceof Page_Main)){
			throw new Page_Main_Invalid_Exception($class, $this);
		}
		
		$this->blocks = Page_Block::Load($this->resource()->get_id());
	}
	
	public static function Load($resource){
		try {
			if($resource == ''){
				$resource = 'home';
			}
			return new Page(Resource::Load($resource));
		} catch(Exception $e){
			// Noooooooooo! Exception
			
			// Let's try again with a Page_Error
			
			// TODO: Implement Page_Error
			
			throw $e;
		}
	}
	
	
}