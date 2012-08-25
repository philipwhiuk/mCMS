<?php
abstract class Simm_Page_Main extends Page_Main {
	public static function Load($parent) {
		$exceptions = array();
		$arg = $parent->resource()->get_argument();	
		switch($arg){
			case 'position':			// Information on a position
			case 'bio':					// Character Biography
			case 'manifest':			// Manifest
			case 'department':			// Information on a department (not of a specific simm)
			case 'spec':				// Specifications of a piece of technology
			case 'fleet':				// Details on a fleet
			case 'simm':				// Details on a SIMM
			case 'uniform':				// Details on a uniform
			case 'rank':				// Details on a rank
			case 'mission':				// Details on a mission
			case 'post':				// Details on a post
				$parent->resource()->consume_argument();
				$parent->resource()->get_module()->file('page_main/'.$arg);
				$class = "Simm_Page_Main_".$arg;
				return $class::Load($parent);
				break;
		}
		throw new Page_Main_Resource_Not_Found_Exception();
	}
	protected function checkManifestModes($mode){
		$id = $this->manifest->id();
		$perms = Permission::Check(array('bio',$id), array('view','edit','add','delete','list','admin'),$mode);
		$system = MCMS::Get_Instance();
		$language = Language::Retrieve();
		$module = Module::Get('simm');

		$this->modes = array();
		foreach($perms as $k => $allowed){
			if($allowed && in_array($k, array('view','edit','delete'))){
				// Create linkage.
				// Link to content/id/mode - grab language junk
				$res = Resource::Get_By_Argument(Module::Get('simm'),'manifest'.$id .'/' . $k);
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