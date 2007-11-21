<?php

/**
 * Index File
 *
 * Subversion ID: $Id$
**/

class Fusion {

	function __construct(){
		// On construction of a Fusion Object, we load the APIs.
		$this->api = array();
		$files = scandir(FUSION_API):
		foreach($files as $file){
			if(is_file(FUSION_API . '/' . $file)){
				$e = explode('.', $file, 2);
				if(isset($e[1]) && $e[1] == 'php' && $e[0] != 'index'){
					require_once(FUSION_API . '/' . $file);
					if(class_exists($e[0]) && method_exists($e[0], 'api_load')){
						$this->api[$e[0]] = call_user_func(array($e[0], 'api_load'), $this);
					} else {
						$this->api[$e[0]] = true;
					}
				}
			}
		}
		$this->hook('Fusion_Construct');	
	}
	
	function error($code, $string, $parameters){
		/**
		Implement
		
		if(isset($this->locale)){
			die(vspring
		} else {
		
		} 
		
		**/
	}
	
	function hook($name);
		$args = func_get_args();
		$return = array();
		$args[0] = $this;
		foreach($this->hooks[$name] as $api){
			$return[] = call_user_func_array(array($api, 'api_hook_' . $name), $args); // API::API_Hook_{NAME} (Fusion, ...)
		}
		return $return;
	}
	
	function load(){
		$this->config = Config::File($this);
		$this->storage = Storage::Start($this, $this->config);
		Config::Storage($this, $this->config);
		$this->acl = ACL::Load($this);
	}
	
	function logic(){
		$this->user = User::Load($this);
		$this->locale = Locale::Load($this):
		$this->page = Page::Load($this):
		
		$this->page->logic();
	}
	
	function output(){
		$this->output = Output::Load($this);		// Load the output module
		
		$this->page->output();						// Generate templates etc
		
		$this->output->output($this->page)			// Display the page using the output module
	}
	
	function unload(){
		Storage::Stop($this);
	}

}

$fusion = new Fusion();
$fusion->load();
$fusion->logic();
$fusion->output();
$fusion->unload();
