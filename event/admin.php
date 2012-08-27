<?php
abstract class Event_Admin extends Admin {

	protected $parent;
	protected $mode;
	private $pages;
	private $events = array();
	
	public static function Load_Menu($panel, $parent) {
		$panel['module']->file('admin/menu');
		return new Event_Admin_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'edit':
					$parent->resource()->consume_argument();
					$panel['module']->file('admin/edit');					
					return new Event_Admin_Edit($panel,$parent);
					break;
				case 'list':
					$parent->resource()->consume_argument();
				default:
					$panel['module']->file('admin/list');				
					return new Event_Admin_List($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$panel['module']->file('admin/list');		
			return new Event_Admin_List($panel,$parent);		
		}
	}
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();
		Permission::Check(array('event'), array('view','edit','add','delete','list','admin'),'admin');

	}
	public static function event_sort($a,$b) {
		if(
		   strtolower(
					  $a->get_content()->get_title()
			) == strtolower($b->get_content()->get_title())) {
			return 0;
		}
		else {
			return (strtolower($a->get_content()->get_title()) < strtolower($b->get_content()->get_title())) ? -1 : 1;
		}
	}




}
