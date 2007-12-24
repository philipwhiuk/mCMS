<?php

/**
 * Index File
 *
 * Subversion ID: $Id$
**/

function __autoload($class){
	if(is_file('./api/' . $class . '.php')){
		require_once('./api/' . $class . '.php');
	}
}

class Fusion {

	static  $_;
	
	function __construct(){
		$this->api = array();
		$files = scandir('./api/');
		foreach($files as $file){
		if(is_file('./api/' . $file)){
				$e = explode('.', $file, 2);
				if(isset($e[1]) && $e[1] == 'php' && $e[0] != 'index'){
					require_once('./api/' . $file);
					if(class_exists($e[0]) && method_exists($e[0], 'api_load')){
						$this->api[$e[0]] = call_user_func(array($e[0], 'api_load'), $this);
					} else {
						$this->api[$e[0]] = true;
					}
				}
			}
		}
		$this->hook('Fusion/Construct');	
	}
	
	function hook($name){
		$return = array();
		if(isset($this->hooks[$name])){
			$args = func_get_args();
			$args[0] = $this;
			foreach($this->hooks[$name] as $api){
				$return[] = call_user_func_array(array($api, 'api_hook_' . $name), $args); // API::API_Hook_{NAME} (Fusion, ...)
			}
		}
		return $return;
	}
	
	function load(){
		$this->log = Log::Open();
		$this->config = Config::File();
		$this->storage = Storage::Load();
		Config::Storage();
	}
	
	function personalize(){
		$this->auth = Authentication::Load();
		$this->user = User::Load();
		$this->locale = Locale::Load();
	}
	
	function run(){
		$this->page = Page::Load();
		return $this->page->run();
	}
	
	function output(){
		$this->output = Output::Load();
		$this->output->run();
		$this->output->output($this->page->output());
	}
	
}

Fusion::$_ = new Fusion;
Fusion::$_->load();
Fusion::$_->personalize();
if(Fusion::$_->run()){
	Fusion::$_->output();
}
