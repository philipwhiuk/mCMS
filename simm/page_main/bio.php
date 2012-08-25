<?php
abstract class Simm_Page_Main_Bio extends Simm_Page_Main {
	public static function Load($parent) {
		$ID = $parent->resource()->get_argument();
		if(is_numeric($ID)) {
			try {
				$ID = $parent->resource()->get_argument();					
				$character = Simm_Character::Get_By_ID($ID);
				$parent->resource()->consume_argument();
				$mode = $parent->resource()->get_argument();
				switch($mode) {
					case 'edit':
						$parent->resource()->get_module()->file('page_main/bio/edit');
						$parent->resource()->consume_argument();
						return new Simm_Page_Main_Bio_Edit($parent, $character);		
						break;
					case 'view':
					default:
						$parent->resource()->get_module()->file('page_main/bio/view');
						$parent->resource()->consume_argument();
						return new Simm_Page_Main_Bio_View($parent, $character);		
						break;
				}
			} catch(Character_Not_Found_Exception $e) {
				throw new Page_Main_Resource_Not_Found_Exception();
			}
		}
		throw new Page_Main_Resource_Not_Found_Exception();
	}
	protected function check($mode){
		$id = $this->character->id();
		$perms = Permission::Check(array('bio',$id), array('view','edit','add','delete','list','admin'),$mode);
		$system = MCMS::Get_Instance();
		$language = Language::Retrieve();
		$module = Module::Get('simm');

		$this->modes = array();
		foreach($perms as $k => $allowed){
			if($allowed && in_array($k, array('view','edit','delete'))){
				// Create linkage.
				// Link to content/id/mode - grab language junk
				$res = Resource::Get_By_Argument(Module::Get('simm'),'bio'.$id .'/' . $k);
				$this->modes[$k] = array(
					'label' => $language->get($module, array('modes',$k)),
					'url' => $system->url($res->url()),
					'selected' => ($mode == $k)
				);
			}
		}
		// can now throw $this->modes at display :-)
	}

}