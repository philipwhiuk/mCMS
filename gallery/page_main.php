<?php

abstract class Gallery_Page_Main extends Page_Main {


	// 1/2/3/4/image/456/view

	public static function Load($parent){
		$arg = $parent->resource()->get_argument();
		$gallerys = array();
		$gallery = 0;
		
		while(is_numeric($arg)){
			$gallery = Gallery::Get_By_ID_Parent((int) $arg, $gallery);
			$gallerys[] = $gallerys;
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();	
		} 

		if($arg == 'object'){
			// Member View
			
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();
			if(is_numeric($arg)){
				$class = $gallery->module()->load_section('Gallery_Item');
				$object = call_user_func(array($class, 'Get_By_Gallery_ID'), $gallery, (int) $arg);
				$parent->resource()->consume_argument();

				if($arg == 'view'){ 
					$parent->resource()->consume_argument();
				}
				
				$parent->resource()->get_module()->file('page_main/item/view');
				return new Gallery_Page_Main_Item_View($parent, $gallery, $object);
			} 
		} else {
			if($arg == 'view'){ 
				$parent->resource()->consume_argument();
			}

			$parent->resource()->get_module()->file('page_main/view');
			return new Gallery_Page_Main_View($parent, $gallery);
		}

	}

}

