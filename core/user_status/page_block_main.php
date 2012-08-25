<?php

abstract class User_Status_Page_Block_Main extends Page_Block_Main {
	public static $ANONYMOUS = 1;
	
	public static function Load($parent){
		$exceptions = array();
		$user = Authentication::Retrieve();
		if($user->get_id() != self::$ANONYMOUS) {
			try {
				switch($parent->resource()->get_argument()){
					case "view":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_block_main/status_view');
						return new User_Status_Page_Block_Main_Status_View($parent, $user);
						break;
				}
				$parent->resource()->module->file('page_block_main/view');
				return new User_Status_Page_Block_Main_Status_View($parent, $user);
			} catch(Exception $e){
				$exceptions[] = $e;
			}
			
		}
		else {
			try {
				switch($parent->resource()->get_argument()){
					case "view":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_block_main/login_view');
						return new User_Status_Page_Block_Main_Login_View($parent, $user);
						break;
				}
				$parent->resource()->module->file('page_block_main/view');
				return new User_Status_Page_Block_Main_Login_View($parent, $user);
			} catch(Exception $e){
				$exceptions[] = $e;
			}
		}
		var_dump($exceptions);
		throw new User_Status_Page_Block_Unavailable_Exception($exceptions);
		
	}
	
}