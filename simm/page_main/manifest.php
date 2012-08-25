<?php
abstract class Simm_Page_Main_Manifest extends Simm_Page_Main {
	public static function Load($parent) {
		$ID = $parent->resource()->get_argument();
		if(is_numeric($ID)) {
			try {
				$manifest = Simm_Manifest::Get_By_ID($ID);
				$parent->resource()->consume_argument();
				$mode = $parent->resource()->get_argument();
				switch($mode) {
					case 'edit':
						$parent->resource()->get_module()->file('page_main/manifest/edit');
						$parent->resource()->consume_argument();
						return new Simm_Page_Main_Manifest_Edit($parent, $manifest);		
						break;
					case 'view':
					default:
						$parent->resource()->get_module()->file('page_main/manifest/view');
						$parent->resource()->consume_argument();
						return new Simm_Page_Main_Manifest_View($parent, $manifest);		
						break;
				}
			} catch(Simm_Manifest_Not_Found_Exception $e) {
				throw new Page_Main_Resource_Not_Found_Exception($e);
			}
		}
		throw new Page_Main_Resource_Not_Found_Exception();
	}
}