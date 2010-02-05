<?php

abstract class Menu_Page_Block_Main extends Page_Block_Main {
	
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if(is_numeric($arg)){
			try {
				$menu = Menu::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				switch($parent->resource()->get_argument()){
					case "view":
						$parent->resource()->get_module()->file('menu_page_block_main_view');
						$class = $menu->module()->load_section("Menu_Page_Block_Main_View");
						$parent->resource()->consume_argument();
						return new $class($parent, $menu);
						break;
				}
				
				$parent->resource()->module->file('page_block_main/view');
				return new Menu_Page_Block_Main_View($parent, $content);
			} catch(Exception $e){
				$exceptions[] = $e;
			}
			
		}
		
		throw new Menu_Page_Unavailable_Exception($exceptions);
		
	}
	
}

