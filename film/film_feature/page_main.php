<?php

abstract class Film_Feature_Page_Main extends Page_Main {
	
	public static function Load($parent){
		
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		
		if($arg == 'add'){
			$parent->resource()->get_module()->file('page_main/add');
			$parent->resource()->consume_argument();
			return new Film_Feature_Main_Add($parent);
		} elseif(is_numeric($arg)){
			try {
				$content = Film_Feature::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				switch($parent->resource()->get_argument()){
					case "edit":
						$parent->resource()->get_module()->file('page_main/edit');
						$parent->resource()->consume_argument();
						return new Film_Feature_Page_Main_Edit($parent, $content);
						break;
					case "view":
						$parent->resource()->get_module()->file('page_main/view');
						$parent->resource()->consume_argument();
						return new Film_Feature_Page_Main_View($parent, $content);
						break;
					case "filmlist":
						$parent->resource()->get_module()->file('page_main/filmlist');
						$parent->resource()->consume_argument();
						return new Film_Feature_Page_Main_FilmList($parent, $content);
						break;
				}
				
				$parent->resource()->get_module()->file('page_main/view');
				return new Film_Feature_Page_Main_View($parent, $content);
			} catch(Exception $e){
				// Content Invalid / Unavailable
				$exceptions[] = $e;
			}
			
		} else { // arg = list
			$parent->resource()->get_module()->file('page_main/list');
			$parent->resource()->consume_argument();
			return new Film_Feature_Page_Main_List($parent);
		}
		
		throw new Film_Feature_Page_Unavailable_Exception($exceptions);
		
	}
	
}