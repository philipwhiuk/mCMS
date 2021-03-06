<?php

abstract class Film_Festival_Page_Main extends Page_Main {
	
	public static function Load($parent){
		
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		
		if($arg == 'add'){
			$parent->resource()->get_module()->file('page_main/add');
			$parent->resource()->consume_argument();
			return new Film_Festival_Main_Add($parent);
		} elseif(is_numeric($arg)){
			try {
				$content = Film_Festival::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				switch($parent->resource()->get_argument()){
					case "edit":
						$parent->resource()->get_module()->file('page_main/edit');
						$parent->resource()->consume_argument();
						return new Film_Festival_Page_Main_Edit($parent, $content);
						break;
					case "view":
						$parent->resource()->get_module()->file('page_main/view');
						$parent->resource()->consume_argument();
						return new Film_Festival_Page_Main_View($parent, $content);
						break;
				}
				
				$parent->resource()->get_module()->file('page_main/view');
				return new Film_Festival_Page_Main_View($parent, $content);
			} catch(Exception $e){
				// Content Invalid / Unavailable
				$exceptions[] = $e;
			}
			
		} else { // arg = list
			try {
				$parent->resource()->get_module()->file('page_main/list');
				$parent->resource()->consume_argument();
				return new Film_Festival_Page_Main_List($parent);
			}
			catch (Exception $e) {
			}
		}
		
		throw new Film_Festival_Page_Unavailable_Exception($exceptions);
		
	}
	
}