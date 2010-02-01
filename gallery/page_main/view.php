<?php

// 1/2/3/view/gallery/4/5/6/object/46


class Gallery_Page_Main_View extends Gallery_Page_Main {
	public function __construct($parent, $gallery){
		parent::__construct($parent);
		Module::Get('gallery')->file('gallery_item/page_main/view');
		Permission::Check(array('gallery',$gallery->id()), array('view','edit','add','delete'),'view');
		$g = $this->gallery = $gallery;
		$g->content();

		$gp = -1;

		$this->selected = array();

		// Create Trails.
		
		$arg = $parent->resource()->get_argument();

		if($arg == 'gallery'){
			$this->selected['gallery'] = array();
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();
			while(is_numeric($arg)){
				$this->selected['gallery'][] = (int) $arg;
				$parent->resource()->consume_argument();
				$arg = $parent->resource()->get_argument();
			}
			if(count($this->selected['gallery']) != 0){ $gp = 0; }
		}

		if($arg == 'object'){
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();
			if(is_numeric($arg)){
				$this->selected['object'] = $arg;
				$parent->resource()->consume_argument();
			}
		}


		$continue = true;
		while($continue){
			$g->selected = true;
			$c = $g->children();
			$o = $g->objects();
			$g->items = array();

			foreach($c as $child){ $child->content(); }

			if($gp !== -1 && isset($this->selected['gallery'][$gp]) && isset($c[$this->selected['gallery'][$gp]])){
				// Select Gallery!
				$g = $c[$this->selected['gallery'][$gp]];
				$gp ++;
			} elseif(isset($this->selected['object']) && isset($o[$this->selected['object']])){
				$continue = false;
				$o[$this->selected['object']]->selected = true;
			} elseif(count($o) == 0 && count($c) > 0){
				$gp = -1; // Invalidate
				reset($c);
				$g = current($c);
			} else {
				$continue = false;
				reset($o);
				$oo = current($o);
				$oo->selected = true;
			}

			if(count($o) > 0){
				$g->section = $class = $g->module()->load_section('Gallery_Item_Page_Main_View');
				foreach($o as $k => $object){
					$g->items[$k] = new $class($object);
				}
			}

		} 
	}

	public function display_sub(&$g, &$t, $furl, $surl, $first){
		if(!$first){
			$furl .= $g->id() . '/';
			$surl .= $g->id() . '/';
		}
		$rf = Resource::Get_By_Argument($this->module, $furl);
		$rs = Resource::Get_By_Argument($this->module, $surl);
		$t = array(
			'title' => $g->content()->get_title(),
			'body' => $g->content()->get_body(),
			'furl' => $this->system->url($rf->url()),
			'surl' => $this->system->url($rs->url()),
			'children' => array(),
			'objects' => array(),
			'selected' => isset($g->selected) ? $g->selected : false
		);
		
		if(isset($g->items) && count($g->items) > 0){
			foreach($g->items as $g => $item){
				$t['objects'][$g] = $item->display();
				if($item->selected()){
					$t['objselected'] = $g;
				}
			}		
		}

		if(isset($g->selected) && $g->selected){
			foreach($g->children() as $sg){
				$st = &$t['children'][];
				$this->display_sub($sg, $st, $furl, $surl, false);
			}
		}
	}

	public function display(){
		$this->system = System::Get_Instance();
		$this->module = Module::Get('gallery');
		$template = $this->system->output()->start(array('gallery','page','view'));
		
		$g = $this->gallery;
		$template->gallery = array();
		$t = &$template->gallery;

		$url = join('/',$this->gallery->parents()). '/';

		$this->display_sub($g, $t, $url, $url . 'view/gallery/', true );
		return $template;
	}	

}
