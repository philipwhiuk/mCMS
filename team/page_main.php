<?php

abstract class Team_Page_Main extends Page_Main {

	// 1/2/3/4/member/view

	public static function Load($parent){
		$arg = $parent->resource()->get_argument();
		$teams = array();
		$team = 0;
		
		while(is_numeric($arg)){
			$team = Team::Get_By_ID_Parent((int) $arg, $team);
			$teams[] = $team;
			$parent->resource()->consume_argument();
			$arg = $parent->resource()->get_argument();	
		} 
		if($arg == 'member'){
			// Member View
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
			}
		} else {
			if($arg == 'view'){ 
				$parent->resource()->consume_argument();
			}

			$parent->resource()->get_module()->file('page_main/view');
			return new Team_Page_Main_View($parent, $team);
		}

	}

}
