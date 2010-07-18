<?php
class Profile_Page_Main {
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if($arg == 'user') {
			$parent->resource()->consume_argument();
			$user = $parent->resource()->get_argument();
			if(is_numeric($user)) {
				try {
					User::Get_By_ID($user);
					$parent->resource()->consume_argument();
					$arg = $parent->resource()->get_argument();
					if($arg == 'edit') {
						$parent->resource()->get_module()->file('page_main/user_edit');
						$parent->resource()->consume_argument();
						return new Profile_Page_Main_User_View($user,$parent);
					}
					else {
						if($arg == 'view') {
							$parent->resource()->consume_argument();
						}
						$parent->resource()->get_module()->file('page_main/user_view');
						return new Profile_Page_Main_User_Edit($user,$parent);
					}
				}
				catch (Exception $e) {
					throw new Profile_User_Page_Not_Found_Exception();
				}
			}
			else {
				throw new Profile_User_Page_Not_Found_Exception();	
			}
		}
		elseif($arg == 'field') {
			
		}
		throw new Profile_Page_Unavailable_Exception($exceptions);
	}
}