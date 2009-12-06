<?php

class Menu_Page_Block_Main_View extends Content_Page_Block_Main {
	
	private $menu;
	private $resources;
	
	public function __construct($parent, $menu){
		parent::__construct($parent);
		
		// Optimization
		
		Permission::Check(array('menu',$menu->id()), array('view','edit','add','delete'),'view');
		
		$this->menu = $menu;
		$this->resources = $this->menu->resources(); // Check permissions at some point :-)
		
		foreach($this->resources as $k => $resource){
			try {
				Permission::Check(array('menu',$menu->id(), $resource->id()), array('view','edit','add','delete'),'view');
			} catch(Exception $e){
				unset($this->resources[$k]);
			}
		}
		
		
	}
	
	public function display(){
		$system = System::Get_Instance();
		
		$template = $system->output()->start(array('menu','page','block','view'));
		
		$resources = $this->resources;
		
		// $eqRating represents the current equality between components
		
		$eqRating = $this->menu->req_factor();
		$current = null;
		
		$parent = $this->parent->parent();
		
		foreach($resources as $k => $resource){
			try {
				if($eqRating !== true){
					$eqC = $resource->resource()->equal($parent);
					if($eqC === true){
						$eqRating = $eqC;
						$current = $resource;
					} elseif($eqC > $eqRating){
						$eqRating = $eqC;
						$current = $resource;
					}
				}
				$template->items[$resource->id()] = array(
					'name' => $resource->name(),
					'url' => $system->url($resource->resource()->url()),
					'children' => array(),
					'parent' => false,
					'current' => false,
					'trail' => false
				);
			} catch(Exception $e){
				unset($resources[$k]);
			}
		}
		
		foreach($resources as $resource){
			$parent = $resource->parent();
			$id = $resource->id();
			if(isset($template->items[$parent])){
				$template->items[$parent]['children'][] =& $template->items[$id];
				$template->items[$id]['parent'] =& $template->items[$parent]; 
			} else {
				$template->items[0]['children'][] =& $template->items[$id];
				$template->items[$id]['parent'] =& $template->items[0];
			}
		}
		
	
		if(isset($current) && isset($template->items[$current->id()])){
			$template->items[$current->id()]['current'] = true;
			$c =& $template->items[$current->id()];
			$continue = true;
			while($continue !== false){
				$c['trail'] = true;
				if(isset($c['parent']) && $c['parent'] != false && isset($c['parent']['trail']) && $c['parent']['trail'] != true){
					$c =& $c['parent'];
				} else {
					$continue = false;
				}
			}
		}
		
		return $template;
	}
	
}