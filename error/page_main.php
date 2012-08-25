<?php
abstract class Error_Page_Main extends Page_Main {
	public static function Load($parent){
		$mode = $parent->resource()->get_argument();
		switch($mode) {
			case 'view':
			default:
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/view');
				return new Error_Page_Main_View($parent);		
				break;
		}
	}
}