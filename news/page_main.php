<?php

abstract class News_Page_Main extends Page_Main {
	
	public static function Load($parent){
		
		// cases:
		
		// 1/2/3/4/5/6/7/article/110
		
		$arg = $parent->resource()->get_argument();
		$categories = array();
		$category = 0;
		
		while(is_numeric($arg)){
			$category = News_Category::Get_By_ID_Parent((int) $arg, $category);
			$categories[] = $category;
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();	
		}
		
		if($arg == 'article'){
			// Article Handler
			$parent->resource()->consume_argument();
			
			$arg = $parent->resource()->get_argument();	
			
			if($arg == 'add'){
				
				
			} elseif(is_numeric($arg)){
				$article = News_Article::Get_By_ID_Category((int) $arg, $category);
				$parent->resource()->consume_argument();
				
				$arg = $parent->resource()->get_argument();
				
				if($arg == 'edit'){
					// Edit Article
				} else {
					// View Article
					
					if($arg == 'view'){
						$parent->resource()->consume_argument();
					}
					
					$parent->resource()->get_module()->file('page_main/article/view');
					return new News_Page_Main_Article_View($parent, $category, $article);
					
				}
				
			}
			
			
		} elseif($arg == 'add'){
			// Add category to category
			
		} else {
			// List everything in the category
			if($arg == 'list'){
				$parent->resource()->consume_argument();
			}
			
			$parent->resource()->get_module()->file('page_main/category/list');
			return new News_Page_Main_Category_List($parent, $category);
		}
		
	}
	
}