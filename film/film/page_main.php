<?php

abstract class Film_Page_Main extends Page_Main {
	
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if($arg == 'add'){
			$parent->resource()->get_module()->file('page_main/add');
			$parent->resource()->consume_argument();
			return new Film_Page_Main_Add($parent);
		} elseif(is_numeric($arg)){
			try {
				$film = Film::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				switch($parent->resource()->get_argument()){
					case "edit":
						$parent->resource()->get_module()->file('page_main/edit');
						$parent->resource()->consume_argument();
						return new Film_Page_Main_Edit($parent, $film);
						break;
					case "view":
						$parent->resource()->get_module()->file('page_main/view');
						$parent->resource()->consume_argument();
						return new Film_Page_Main_View($parent, $film);
						break;
				}
				
				$parent->resource()->get_module()->file('page_main/view');
				return new Film_Page_Main_View($parent, $film);
			} catch(Exception $e){
				// Content Invalid / Unavailable
				$exceptions[] = $e;
			}
			
		} elseif($arg == 'genre') {
			$parent->resource()->get_module()->file('page_main/genre');
			$parent->resource()->consume_argument();
			return new Film_Page_Main_Genre($parent);
			exit();
		} elseif($arg == 'language') {
			$parent->resource()->get_module()->file('page_main/language');
			$parent->resource()->consume_argument();
			return new Film_Page_Main_Language($parent);
			exit();
		}
		 else { // list or N/A
			$parent->resource()->get_module()->file('page_main/list');
			$parent->resource()->consume_argument();
			return new Film_Page_Main_List($parent);
		}
		
		throw new Film_Page_Unavailable_Exception($exceptions);
		
	}
	
}