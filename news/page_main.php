<?php

abstract class News_Page_Main extends Page_Main {

	protected function check($mode){
		$id = $this->content->id();
		$perms = Permission::Check(array('content',$id), array('view','edit','add','delete','list','admin'),'view');
		$system = System::Get_Instance();
		$language = Language::Retrieve();
		$module = Module::Get('content');

		$this->modes = array();
		foreach($perms as $k => $allowed){
			if($allowed && in_array($k, array('view','edit','delete'))){
				// Create linkage.
				// Link to content/id/mode - grab language junk
				$res = Resource::Get_By_Argument(Module::Get('content'),$id .'/' . $k);
				$this->modes[$k] = array(
					'label' => $language->get($module, array('modes',$k)),
					'url' => $system->url($res->url()),
					'selected' => ($mode == $k)
				);
			}
		}
		// can now throw $this->modes at display :-)
	}

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

			} else if($arg == 'latest'){			// Latest from Category.
				$article = News_Article::Latest_By_Category($category);
				$parent->resource()->consume_argument();
				$arg = $parent->resource()->get_argument();
				if($arg == 'edit'){
					// Edit Article
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('page_main/article/edit');
					return new News_Page_Main_Article_Edit($parent, $category, $article);
				} else {
					// View Article
					if($arg == 'view'){
						$parent->resource()->consume_argument();
					}
					$parent->resource()->get_module()->file('page_main/article/view');
					return new News_Page_Main_Article_View($parent, $category, $article);
					
				}
			} elseif(is_numeric($arg)){			// ID from Category
				$article = News_Article::Get_By_ID_Category((int) $arg, $category);
				$parent->resource()->consume_argument();
				$arg = $parent->resource()->get_argument();
				try {
					if($arg == 'edit'){
						// Edit Article
						$parent->resource()->consume_argument();
						$parent->resource()->get_module()->file('page_main/article/edit');
						return new News_Page_Main_Article_Edit($parent, $category, $article);
					} else {
						// View Article
						if($arg == 'view'){
							$parent->resource()->consume_argument();
						}
						$parent->resource()->get_module()->file('page_main/article/view');
						return new News_Page_Main_Article_View($parent, $category, $article);
					}
				}
				catch(Exception $e) {
					// Try and View
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
		return new News_Page_Main_Unavailable_Exception($parent);
	}
	
}
