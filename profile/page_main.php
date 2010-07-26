<?php
abstract class Profile_Page_Main extends Page_Main {
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if(is_numeric($arg)) {
			try {
				$user = User::Get_By_ID($arg);
				$parent->resource()->consume_argument();
				$arg = $parent->resource()->get_argument();
				if($arg == 'edit') {
					$parent->resource()->get_module()->file('page_main/edit');
					$parent->resource()->consume_argument();
					return new Profile_Page_Main_Edit($user,$parent);
				}
				else {
					if($arg == 'view') {
						$parent->resource()->consume_argument();
					}
					$parent->resource()->get_module()->file('page_main/view');
					return new Profile_Page_Main_View($user,$parent);
				}
			}
			catch (Exception $e) {
				throw new Profile_User_Page_Not_Found_Exception($arg);
			}
		}
		else {
			throw new Profile_User_Page_Not_Found_Exception();	
		}
	}
}