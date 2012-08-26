<?php

abstract class Film_Admin extends Admin {

	protected $parent;
	protected $mode;
	
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Film_Admin_Menu($panel,$parent);
	}
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/edit');					
					return new Film_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Film_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Film_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('film'), array('view','edit','add','delete','list','admin'),'admin');
	}
	public static function film_sort($a,$b) {
		try {
			$atitle = $a->get_description()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$atitle = '';
		}
		try {
			$btitle = $b->get_description()->get_title();
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
	public function display(){
		if($this->mode == 'list'){
			return $this->display_list();
		} elseif($this->mode == 'edit'){
			return $this->display_edit();
		} 
	}

}
