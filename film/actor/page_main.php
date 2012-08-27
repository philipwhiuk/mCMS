<?php

abstract class Actor_Page_Main extends Page_Main {
	
	protected $modes;
	protected $content;

	// Check permissions and setup modes.
	// Doing this here allows us to change the mode list easily which is cool.

	// NB List may cause problems - rework?

	protected function check($mode){
		$id = $this->actor->id();
		$perms = Permission::Check(array('actor',$id), array('view','edit','add','delete','list'),'view');
		$system = MCMS::Get_Instance();
		$language = Language::Retrieve();
		$module = Module::Get('actor');

		$this->modes = array();
		foreach($perms as $k => $allowed){
			if($allowed && in_array($k, array('view','edit','delete'))){
				// Create linkage.
				// Link to actor/id/mode - grab language junk
				$res = Resource::Get_By_Argument(Module::Get('actor'),$id .'/' . $k);
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
		
		$exceptions = array();
		$arg = $parent->resource()->get_argument();
		if($arg == null) {
			$arg = 'list';
		}
		if($arg == 'add'){
			$parent->resource()->get_module()->file('page_main/add');
			$parent->resource()->consume_argument();
			return new Actor_Page_Main_Add($parent);
		} elseif($arg == 'list'){
			$parent->resource()->get_module()->file('page_main/list');
			$parent->resource()->consume_argument();
			return new Actor_Page_Main_List($parent);
		} elseif(is_numeric($arg)){
			try {
				$actor = Actor::Get_By_ID((int) $arg);
				$parent->resource()->consume_argument();
				try {
					switch($parent->resource()->get_argument()){
						case "edit":
							$parent->resource()->get_module()->file('page_main/edit');
							$parent->resource()->consume_argument();
							return new Actor_Page_Main_Edit($parent, $actor);
							break;
						default:
						case "view":
							$parent->resource()->get_module()->file('page_main/view');
							$parent->resource()->consume_argument();
							return new Actor_Page_Main_View($parent, $actor);
							break;
					}
				}
				catch(Exception $e) {
					$exceptions[] = $e;
					$parent->resource()->get_module()->file('page_main/view');
					return new Actor_Page_Main_View($parent, $actor);
				}				
			} catch(Exception $f){
				$exceptions[] = $f;
				// Actor Invalid / Unavailable
			}
			
		}
		throw new Actor_Page_Unavailable_Exception($exceptions);
	}
	
}
