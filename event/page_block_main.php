<?php

abstract class Event_Page_Block_Main extends Page_Block_Main {
	
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if($arg == 'next') {
			try {
				$parent->resource()->consume_argument();
				$arg = $parent->resource()->get_argument();
				if(is_numeric($arg)){
					$cat = $arg;
					$parent->resource()->consume_argument();
					$arg = $parent->resource()->get_argument();
					if(is_numeric($arg)){
						$skip = $arg;
					}
					else {
						$skip = 0;
					}
					$parent->resource()->get_module()->file('page_block_main/next');
					$event = Event::Get_Next_By_Category($cat,$skip);
					return new Event_Page_Block_Main_Next($parent, $event);
				}
				$parent->resource()->get_module()->file('page_block_main/next');
				$event = Event::Get_Next();
				return new Event_Page_Block_Main_Next($parent, $event);
			}
			catch(Exception $e){
				$exceptions[] = $e;
			}
		}
		if(is_numeric($arg)){
			try {
				$event = Event::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				switch($parent->resource()->get_argument()){
					case "view":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_block_main/view');
						return new Event_Page_Block_Main_View($parent, $event);
						break;
				}
				
				$parent->resource()->module->file('page_block_main/view');
				return new Event_Page_Block_Main_View($parent, $event);
			} catch(Exception $e){
				$exceptions[] = $e;
			}
			
		}
		
		throw new Event_Page_Unavailable_Exception($exceptions);
		
	}
	
}