<?php

class Page {
	
	private $resource;
	
	private $main;
	private $blocks;
	private $inline;
	
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('page'));
		$template->main = $this->main->display();
		$template->inline = $this->inline;
		$template->blocks = array();
		if(!$this->inline){
			foreach($this->blocks as $block){
				$template->blocks[$block->get_layout()][$block->get_order()][] = $block->display();
			}
			foreach($template->blocks as $layout => $blocks){
				ksort($template->blocks[$layout]);
			}
		}
		return $template;
	}
	
	public function resource(){
		return $this->resource;
	}
	
	public function url($url){
		return MCMS::Get_Instance()->url($url);
	}
	
	public function __construct($resource, $inline){
		$this->resource = $resource;
		$this->inline = $inline;
		$class = $resource->get_module()->load_section('Page_Main');
		$this->main = call_user_func(array($class, 'Load'), $this);
		if(!($this->main instanceof Page_Main)){
			throw new Page_Main_Invalid_Exception($class, $this);
		}
		
		if(!$inline){
			$this->blocks = Page_Block::Load($this->resource());
		}
	}
	
	public static function Load($resource, $inline = false){
		$exceptions = array();
		return new Page($resource, $inline);
	}
	
	
}
