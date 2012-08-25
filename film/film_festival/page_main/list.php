<?php
class Film_Festival_Page_Main_List extends Film_Festival_Page_Main {
	public function __construct($parent) {
		$system = MCMS::Get_Instance();
		$module = Module::Get('film_festival');
		parent::__construct($parent);
		Permission::Check(array('film_festival'), array('view','edit','add','delete','list'),'list');
		$arg = $parent->resource()->get_argument();
		if(is_numeric($arg)) {
			$first = mktime(0,0,0,1,1,$arg);
			$last = mktime(0,0,0,12,31,$arg);
			$this->title = $arg;
		}
		else {
			switch($arg){
				case "archive":
					$first = 0;
					$last = time();
					$this->title = "archive";
					break;
				default:
				case "current":
					$first = time();
					$last = strtotime("+1 year");
					$this->title = "current";
			}
		}
		$this->items = array();
	}
	public function display() {
	try {
		$system = MCMS::Get_Instance();
		$template = $system->output()->start(array('film_festival','page','list'));
		$language = Language::Retrieve();
		$module = Module::Get('film_feature');
		try {
			if(is_numeric($this->title)) {
				$template->title = $language->get($module, array('list','title','year'))." ".$this->title;
			}
			else {
				$template->title = $language->get($module, array('list','title',$this->title));
			}
		} catch (Exception $e) {
			var_dump($e);
		}
		$template->items = $this->items;
		return $template;
	}
	catch(Exception $e) {
		var_dump($e);
	}
	}
}
?>