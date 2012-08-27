<?php
abstract class News_Admin_Article extends News_Admin {
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/article/add');					
					return new News_Admin_Article_Add($panel,$parent);
					break;
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/article/edit');					
					return new News_Admin_Article_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/article/list');				
					return new News_Admin_Article_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/article/list');		
			return new News_Admin_Article_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
	}
}