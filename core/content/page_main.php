<?php
abstract class Content_Page_Main extends Page_Main {
	protected function check_noID($mode){
		$perms = Permission::Check(array('content','list'), array('view','edit','admin'),$mode);
		$system = MCMS::Get_Instance();
		$language = Language::Retrieve();
		$module = Module::Get('content');

		$this->modes = array();
		foreach($perms as $k => $allowed){
			if($allowed && in_array($k, array('view','edit','admin'))){
				// Create linkage.
				// Link to content/id/mode - grab language junk
				$res = Resource::Get_By_Argument(Module::Get('content'),'list/' . $k);
				$this->modes[$k] = array(
					'label' => $language->get($module, array('modes',$k)),
					'url' => $system->url($res->url()),
					'selected' => ($mode == $k)
				);
			}
		}
		// can now throw $this->modes at display :-)
	}
	protected function check($mode){
		$id = $this->content->id();
		$perms = Permission::Check(array('content',$id), array('view','edit','add','delete','list','admin'),$mode);
		$system = MCMS::Get_Instance();
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
		$exceptions = array();
		$arg = $parent->resource()->get_argument();	
		if($arg == 'list') {
			$parent->resource()->consume_argument();
			$mode = $parent->resource()->get_argument();
			$parent->resource()->consume_argument();
			$page = $parent->resource()->get_argument();
			if(!is_numeric($page) || !(((int) $page) > 0)) {
				$page = 1;
			}
			switch($mode) {
				case 'edit':
					$parent->resource()->get_module()->file('page_main/list/edit');
					return new Content_Page_Main_List_Edit($parent, $page);		
					break;
				default:
				case 'view':
					$parent->resource()->get_module()->file('page_main/list/view');
					$parent->resource()->consume_argument();
					return new Content_Page_Main_List_View($parent, $page);		
					break;
			}
			$parent->resource()->get_module()->file('page_main/list/view');
			$parent->resource()->consume_argument();
			return new Content_Page_Main_List_View($parent, $entry);		
		}		
		else if($arg == 'entry') {
			$parent->resource()->consume_argument();
		}
		$ID = $parent->resource()->get_argument();
		if(is_numeric($ID)) {
			try {
				$ID = $parent->resource()->get_argument();					
				$entry = Content::Get_By_ID($ID);
				$parent->resource()->consume_argument();
				$mode = $parent->resource()->get_argument();
				switch($mode) {
					case 'edit':
						$parent->resource()->get_module()->file('page_main/entry/edit');
						$parent->resource()->consume_argument();
						return new Content_Page_Main_Entry_Edit($parent, $entry);		
						break;
					case 'view':
					default:
						$parent->resource()->get_module()->file('page_main/entry/view');
						$parent->resource()->consume_argument();
						return new Content_Page_Main_Entry_View($parent, $entry);		
						break;
				}
			} catch(Content_Not_Found_Exception $e) {
				throw new Page_Main_Resource_Not_Found_Exception();
			}
		}
		else {
			throw new Page_Main_Resource_Not_Found_Exception();
		}
	}
}