<?php

abstract class Simm_Admin extends Admin {
	protected $parent;
	protected $mode;
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Simm_Admin_Menu($panel,$parent);
	}
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'characters':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/characters');					
					return Simm_Admin_Characters::Load_Main($panel,$parent);
					break;
				case 'departments':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/departments');		
					return Simm_Admin_Departments::Load_Main($panel,$parent);
					break;
				case 'fleets':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/fleets');	
					return Simm_Admin_Fleets::Load_Main($panel,$parent);
					break;
				case 'missions':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/missions');					
					return Simm_Admin_Missions::Load_Main($panel,$parent);
					break;
				case 'positions':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/positions');					
					return Simm_Admin_Positions::Load_Main($panel,$parent);
					break;
				case 'ranks':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/ranks');					
					return Simm_Admin_Ranks::Load_Main($panel,$parent);
					break;
				case 'simms':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/simms');					
					return Simm_Admin_Simms::Load_Main($panel,$parent);
					break;
				case 'specifications':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/specifications');		
					return Simm_Admin_Specifications::Load_Main($panel,$parent);
					break;
				case 'technology':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/technology');					
					return Simm_Admin_Technology::Load_Main($panel,$parent);
					break;
				case 'uniforms':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/uniforms');					
					return Simm_Admin_Uniforms::Load_Main($panel,$parent);
					break;
				case 'overview':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/overview');				
					return new Simm_Admin_Overview($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/overview');		
			return new Simm_Admin_Overview($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('content'), array('view','edit','add','delete','list','admin'),'admin');	
	}
}
