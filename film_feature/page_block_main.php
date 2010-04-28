<?php

abstract class Film_Feature_Page_Block_Main extends Page_Block_Main {
	
	public static function Load($parent){
		$exceptions = array();
		switch($parent->resource()->get_argument()) {
			case 'coming_soon':
				$parent->resource()->consume_argument();
				$toShow = $parent->resource()->get_argument();
				$toShow = (int) $toShow;
				try {
					$feature = Film_Feature::Get_ComingSoon($toShow);
					$parent->resource()->consume_argument();
					switch($parent->resource()->get_argument()){
						case "view":
							$parent->resource()->consume_argument();
							$parent->resource()->get_module()->file('page_block_main/coming_soon');
							return new Film_Feature_Page_Block_Main_Coming_Soon($parent, $feature);
							break;
					}
				} catch(Exception $e){
					$exceptions[] = $e;
				}
				break;
			case 'cat_coming_soon':
				$parent->resource()->consume_argument();
				$cat = $parent->resource()->get_argument();
				$cat = (int) $cat;
				$parent->resource()->consume_argument();
				try {
					$category = Film_Feature_Category::Get_By_ID($cat);
					$feature = Film_Feature::Get_Category_Next($category);
					switch($parent->resource()->get_argument()){
						case "view":
							$parent->resource()->consume_argument();
							$parent->resource()->get_module()->file('page_block_main/category_next');
							return new Film_Feature_Page_Block_Main_Category_Next($parent, $feature);
							break;
					}
				} catch(Exception $e){
					$exceptions[] = $e;
				}
				break;
		}
		throw new Film_Feature_Page_Unavailable_Exception($exceptions);
	}
	
}
