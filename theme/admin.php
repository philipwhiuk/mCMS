<?php

abstract class Theme_Admin extends Admin {

	protected $parent;
	protected $mode;

	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Theme_Admin_Menu($panel,$parent);
	}
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/add');					
					return new Theme_Admin_Add($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Theme_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Theme_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('theme'), array('view','edit','add','delete','list','admin'),'admin');
	}
}
