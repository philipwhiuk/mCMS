<?php

/**
 * Index File
 *
 * Subversion ID: $Id$
**/

function error($message){
	Log::Message($message);
	if(defined('FUSION_DEBUG')){
		if(file_exists('krumo/class.krumo.php')){
			header('Content-type: text/html');
			require_once('krumo/class.krumo.php');
			krumo(Fusion::$_);
			krumo::backtrace();
			krumo::includes();
			krumo::functions();
			krumo::classes();
			krumo::defines();
		} else {
			header('Content-type: text/plain');
			print_r(Fusion::$_);
		}
	}
	exit;
}

function __autoload($class){
	if(is_file('./api/' . $class . '.php')){
		require_once('./api/' . $class . '.php');
	}
}

class Fusion {

	static  $_;

	function Redirect($url){
		header("Location: $url");
		exit();
	}

	static function URL($string, $get = true){
		// Helper function
		
		if($get){
			$g = array();
			
			foreach($_GET as $k => $n){
				if($k !== 'page'){
					$g[] = $k . '=' . urlencode($n);
				}
			}
			
			if(count($g) > 0){
				if(strpos($string, '?') === FALSE){
					$string .= '?' . join($g, '&');
				} else {
					$string .= '&' . join($g, '&');
				}
			}
		}
		
		return htmlentities($string);
		
	}

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
				$return[] = call_user_func_array(array($api, 'api_hook_' . str_replace('/', '_',$name)), $args); // API::API_Hook_{NAME} (Fusion, ...)
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
