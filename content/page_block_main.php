<?php

abstract class Content_Page_Block_Main extends Page_Block_Main {
	
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if(is_numeric($arg)){
			try {
				$content = Content::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				switch($parent->resource()->get_argument()){
					case "view":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_block_main/view');
						return new Content_Page_Block_Main_View($parent, $content);
						break;
				}
				
				$parent->resource()->module->file('page_block_main/view');
				return new Content_Page_Block_Main_View($parent, $content);
			} catch(Exception $e){
				$exceptions[] = $e;
			}
			
		}
		throw new Content_Page_Block_Unavailable_Exception($exceptions);
		
	}
	
}