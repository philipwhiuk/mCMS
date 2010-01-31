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

		if($arg == 'image'){
			// Member View
			exit('Implement image viewer');
			/*
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();
			if(is_numeric($arg)){
				$member = Team_Member::Get_By_ID_Team((int) $arg, $team);
				$parent->resource()->consume_argument();

				if($arg == 'view'){
					$parent->resource()->consume_argument();
				}

				$parent->resource()->get_module()->file('page_main/member/view');

				return new Team_Page_Main_Member_View($parent, $team, $member);
			} */
		} else {
			if($arg == 'view'){ 
				$parent->resource()->consume_argument();
			}

			$parent->resource()->get_module()->file('page_main/view');
			return new Gallery_Page_Main_View($parent, $gallery);
		}

	}

}

