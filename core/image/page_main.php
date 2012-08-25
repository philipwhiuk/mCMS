<?php

abstract class Image_Page_Main extends Page_Main {
	
	public static function Load($parent){
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		
		if($arg == 'list'){
			$parent->resource()->consume_argument();
			$parent->resource()->get_module()->file('page_main/list');
			return new Image_Page_Main_List($parent);
		} elseif(is_numeric($arg)){
			try {
				$image = Image::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				
				$arg = $parent->resource()->get_argument();
				if(is_numeric($arg)){
					try {
						$file = Image_File::Get_By_ID_Image((int) $arg, $image);
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_main/file');
						return new Image_Page_Main_File($parent, $image, $file);
					} catch(Exception $e){
						// Image File Invalid / Unavailable
						$exceptions[] = $e;
					}
				}
				
				/*
				switch($arg){
					case "edit":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_main/edit');
						return new File_Page_Main_Edit($parent, $file);
						break;
					case "view":
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_main/view');
						return new File_Page_Main_View($parent, $file);
						break;
				}*/
				
				$parent->resource()->get_module()->file('page_main/view');
				return new Image_Page_Main_View($parent, $image);
			} catch(Exception $e){
				// Image Invalid / Unavailable
				$exceptions[] = $e;
			}
			
		}
		
		throw new Image_Page_Unavailable_Exception($exceptions);
	}
	
}