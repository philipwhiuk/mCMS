<?php

abstract class Event_Page_Main extends Page_Main {

	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if($arg == 'add'){
			$parent->resource()->get_module()->file('page_main/add');
			$parent->resource()->consume_argument();
			return new Event_Page_Main_Add($parent);
		} elseif(is_numeric($arg)){
			try {
				$event = Event::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				switch($parent->resource()->get_argument()){
					case "edit":
						$parent->resource()->get_module()->file('page_main/edit');
						$parent->resource()->consume_argument();
						return new Event_Page_Main_Edit($parent, $event);
						break;
					case "view":
						$parent->resource()->get_module()->file('page_main/view');
						$parent->resource()->consume_argument();
						return new Event_Page_Main_View($parent, $event);
						break;
				}
				
				$parent->resource()->get_module()->file('page_main/view');
				return new Event_Page_Main_View($parent, $event);
			} catch(Exception $e){
				// Content Invalid / Unavailable
				$exceptions[] = $e;
				var_dump($e);
			}
			
		} else { // list or N/A
			$parent->resource()->get_module()->file('page_main/list');
			$parent->resource()->consume_argument();
			return new Event_Page_Main_List($parent);
		}
		
		throw new Event_Page_Unavailable_Exception($exceptions);
		
	}
	
}