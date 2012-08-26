<?php

abstract class Film_Feature_Admin extends Admin {
	protected $parent;
	protected $mode;
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Film_Feature_Admin_Menu($panel,$parent);
	}
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		switch($arg) {
			case 'showings':
				$parent->resource()->consume_argument();
				$panel['module']->file('admin/showings');					
				return Film_Feature_Admin_Showings::Load_Main($panel,$parent);
				break;
			case 'features':
				$parent->resource()->consume_argument();
			default:
				$panel['module']->file('admin/features');				
				return Film_Feature_Admin_Features::Load_Main($panel,$parent);
				break;
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		Permission::Check(array('film_feature'), array('view','edit','add','delete','list','admin'),'admin');
		$this->url = $this->url('');
		$this->flist_url = $this->url('features/');
		$this->slist_url = $this->url('showings/');		

	}
	public static function film_feature_sort($a,$b) {
		try {
			$atitle = $a->get_content()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$atitle = '';
		}
		try {
			$btitle = $b->get_content()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$btitle = '';
		}
	
		if(strtolower($atitle) == strtolower($btitle)) {
			return 0;
		}
		else {
			return (strtolower($atitle) < strtolower($btitle)) ? -1 : 1;
		}
	}
}
