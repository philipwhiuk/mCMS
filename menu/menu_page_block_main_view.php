<?php

abstract class Menu_Page_Block_Main_View extends Menu_Page_Block_Main {

	protected $menu;
	protected $impl;
	protected $level;
	protected $eqRating = 0;

	public function __construct($parent, $menu, $parents = array(), $level = 0){
		parent::__construct($parent);		
		Permission::Check(array('menu',$menu->id()), array('view','edit','add','delete'),'view');
		$this->menu = $menu;
		$this->impl = $menu->impl();
		$this->parents = $parents;
		$this->level = $level;
	}

	abstract public function clearRating();

}


class Menu_Menu_Page_Block_Main_View extends Menu_Page_Block_Main_View {

	public function hasTrail(){
		return true;
	}

	public function __construct($parent, $menu, $parents = array(), $level = 0){
		parent::__construct($parent, $menu, $parents, $level);

		$this->eqRating = 0;

		// Get Menu Items

		$parents = $this->parents;
		$parents[] = $menu->id();

		$this->items = $this->impl->items();

		$eqRating = $this->menu->req_factor();

		$eqCurrent = null; $eqOld = null;

		$presource = $this->parent->parent();
	
		foreach($this->items as $item){
			$item->show = true;
			$item->trail = false;
			$item->current = false;
			try {
				$resource = $item->resource();

				Permission::Check(array('menu',$this->menu->id(), $item->id()), array('view','edit','add','delete'),'view');

				$item->logic = false;
				try {
					$menu = $item->child();
					if($menu && !in_array($menu->id(), $parents)){
						$class = $menu->module()->load_section("Menu_Page_Block_Main_View");								$item->logic = new $class($parent, $menu, $parents, $this->level + 1);
					}
				} catch (Exception $e){ 
					$item->logic = false;	
				}

				if($eqRating === true){
					if($item->logic){ $item->logic->clearRating(); }
				} else {
					$iqRating = $resource->equal($presource);
					$cqRating = ($item->logic) ? $item->logic->eqRating : 0;
					
					if($cqRating === true){
                                                $eqOld = $eqCurrent;
                                                $eqCurrent = array($item,false);
                                                $eqRating = true;
                                        } elseif($iqRating === true){
						if($item->logic){ $item->logic->clearRating(); }
						$eqOld = $eqCurrent;
						$eqCurrent = array($item,true);
						$eqRating = true;
					} elseif($cqRating === true){
						$eqOld = $eqCurrent;
						$eqCurrent = array($item,false);
						$eqRating = true;
					} elseif($eqRating >= $iqRating && $eqRating >= $cqRating){
						// We already have a higher child. Override.
						if($item->logic){ $item->logic->clearRating(); }
					} elseif($iqRating > $eqRating && $iqRating >= $cqRating){
						// Direct Child is highest
						if($item->logic){ $item->logic->clearRating(); }
						$eqOld = $eqCurrent;
						$eqCurrent = array($item,true);
						$eqRating = $iqRating;
					} else {
						// Indirect Child is highest
						$eqOld = $eqCurrent;
						$eqCurrent = array($item,false);
						$eqRating = $iqRating;
					}
				}
			} catch(Exception $e){
				// Remove item
				if(isset($eqCurrent) && $eqCurrent[0] == $item){
					if(!$eqCurrent[1]){
						$eqCurrent[0]->logic->clearRating();
					}
					$eqCurrent = $eqOld;
				} 
				$item->show = false;
			}
		}

		if($eqCurrent){
			$eqCurrent[0]->trail = true;
			if($eqCurrent[1]){
				$eqCurrent[0]->current = true;
			}
			$this->eqRating = $eqRating;
			$this->eqCurrent = $eqCurrent;
		} 		
	}

	public function clearRating(){
		if(isset($this->eqCurrent)){
			if(!$this->eqCurrent[1]){
				$this->eqCurrent[0]->logic->clearRating();
			}
			$this->eqCurrent[0]->trail = false;
			$this->eqCurrent[0]->current = false;
		} 
	}

	public function display(){
		$system = System::Get_Instance();
		$template = $system->output()->start(array('menu','page','block','view'));
		$template->level = $this->level;
		$template->id = $this->menu->id();
		$template->items = array();

		foreach($this->items as $item){
			if($item->show){
				$template->items[] = array(
					'name' => $item->name(),
					'url' => $system->url($item->resource()->url()),
					'child' => ($item->logic) ? $item->logic->display() : false,
					'current' => $item->current,
					'trail' => $item->trail
				);
			}
		}

		return $template;
	}

}

/*

class Menu_Page_Block_Main_View extends Content_Page_Block_Main {
	
	private $menu;
	private $resources;
	
	public function __construct($parent, $menu){
		parent::__construct($parent);
		
		// Optimization
		
		Permission::Check(array('menu',$menu->id()), array('view','edit','add','delete'),'view');
		
		$this->menu = $menu;
		$impl = $this->menu->impl();

		
		

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

*/
