<?php

/**
 * Super class for pages showing information on files.
 */
abstract class File_Page_Main extends Page_Main {
	
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		
		if($arg == 'list'){
			$parent->resource()->consume_argument();
			$parent->resource()->get_module()->file('page_main/list');
			return new File_Page_Main_List($parent);
			break;
		} elseif(is_numeric($arg)){
			try {
				$file = File::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				switch($parent->resource()->get_argument()){
					case "edit":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_main/edit');
						return new File_Page_Main_Edit($parent, $file);
						break;
					case "view":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_main/view');
						return new File_Page_Main_View($parent, $file);
						break;
				}
				
				$parent->resource()->get_module()->file('page_main/view');
				return new File_Page_Main_View($parent, $file);
			} catch(Exception $e){
				// Content Invalid / Unavailable
				$exceptions[] = $e;
			}
			
		}
		
		throw new File_Page_Unavailable_Exception($exceptions);
	}
	
}