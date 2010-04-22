<?php

abstract class Film_Page_Block_Main extends Page_Block_Main {
	
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if($arg == 'feature') {
			$parent->resource()->consume_argument();
			return Film_Feature_Page_Block_Main::Load($parent);
		}
		if(is_numeric($arg)){
			try {
				$film = Film::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				switch($parent->resource()->get_argument()){
					case "view":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_block_main/view');
						return new Film_Page_Block_Main_View($parent, $film);
						break;
				}
				
				$parent->resource()->module->file('page_block_main/view');
				return new Film_Page_Block_Main_View($parent, $film);
			} catch(Exception $e){
				$exceptions[] = $e;
			}
			
		}
		
		throw new Film_Page_Unavailable_Exception($exceptions);
		
	}
	
}