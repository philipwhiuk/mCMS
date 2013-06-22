<?php

/**
 * A super class for the dashboard.
 */
abstract class Admin_Dashboard extends Admin {
	protected $parent;
	protected $mode;
	private $selected;

	/**
	 * Load the Menu.
	 */
	public static function Load_Menu($panel, $parent) {
		$parent->resource()->get_module()->file('dashboard/menu');
		return new Admin_Dashboard_Menu($panel,$parent);
	}
	
	/**
	 * Load the Main section.
	 */
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'resources':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/resources');
					return new Admin_Dashboard_Resources($panel,$parent);
					break;
				case 'sites':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/sites');
					return new Admin_Dashboard_Sites($panel,$parent);
					break;					
				case 'modules':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/modules');
					return new Admin_Dashboard_Modules($panel,$parent);
					break;
				case 'updates':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/updates');
					return new Admin_Dashboard_Updates($panel,$parent);
					break;
				case 'settings':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/settings');
					return new Admin_Dashboard_Settings($panel,$parent);
					break;
				case 'statistics':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/statistics');
					return new Admin_Dashboard_Statistics($panel,$parent);
					break;
				case 'overview':
					$parent->resource()->consume_argument();				
				default:
					$parent->resource()->get_module()->file('dashboard/overview');
					return new Admin_Dashboard_Overview($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$parent->resource()->get_module()->file('dashboard/overview');
			return new Admin_Dashboard_Overview($panel,$parent);
		}
	}
	
	/**
	 * Constructor.
	 */
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();		
	}
}
