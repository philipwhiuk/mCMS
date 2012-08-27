<?php
abstract class News_Admin_Category extends News_Admin {
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'add':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/category/add');					
					return new News_Admin_Category_Add($panel,$parent);
					break;
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/category/edit');					
					return new News_Admin_Category_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/category/list');				
					return new News_Admin_Category_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/category/list');		
			return new News_Admin_Category_List($panel,$parent);		
		}
	}
}