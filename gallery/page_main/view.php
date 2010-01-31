<?php

// 1/2/3/view/gallery/4/5/6/object/46


class Gallery_Page_Main_View extends Gallery_Page_Main {
	public function __construct($parent, $gallery){
		parent::__construct($parent);
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
		}
	}

	public function display_sub(&$g, &$t){
		$t = array(
			'title' => $g->content()->get_title(),
			'body' => $g->content()->get_body(),
			'children' => array(),
			'objects' => array(),
			'selected' => isset($g->selected) ? $g->selected : false
		);
		if(isset($g->selected) && $g->selected){
			foreach($g->children() as $sg){
				$st = &$t['children'][];
				$this->display_sub($sg, $st);
			}
		}
	}

	public function display(){
		$system = System::Get_Instance();
		$module = Module::Get('gallery');
		$template = $system->output()->start(array('gallery','page','view'));
		
		$g = $this->gallery;
		$template->gallery = array();
		$t = &$template->gallery;
		$this->display_sub($g, $t);
		return $template;
	}	

}
