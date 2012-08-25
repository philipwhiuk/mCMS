<?php
/*
 * Modular CMS v0.0.1
 * File: mcms.php
 * Version: 0.0.1
 * Purpose: MCMS System Class
 */ 
header('Content-type: text/plain');
ini_set('display_errors', 1); 
error_reporting(error_reporting());
require_once(MCMS::dirname(__FILE__) . '/mcms/exception.php');
 class MCMS {
	private static $instance;
	public static function dirname($file){
		$string = dirname($file);
		return rtrim(str_replace('\\', '/', $string),'/');
	}	
	public static function Get_Instance() {
		// Singleton
		if(!isset(MCMS::$instance)){
			MCMS::$instance = new MCMS();	
		}
		return MCMS::$instance;
		
	}
	
	private $debugging;
	private $log;
	private $debug_type;
	public $debug_default_level;
	private $debug_level;
	private $local_path;
	private $remote_path;
	private $path;
	private $formats;
	
	private $storage;
	private $config;
	private $site;
	public $modules;
	public $exceptions = array();
	
	const dump_notice = 2;
	const dump_warning = 1;
	const dump_error = 0;

	const dump_screen = 0;
	const dump_file = 1;
	const dump_file_log = 2;
	const dump_log = 3;
	const dump_syslog = 4;
	const dump_none = 5;
 
	private function __construct() {
		
		// Okay, we need to create a new MCMS instance
	
		// Use a full url as a default (probably Apache specific)

		$url = rtrim((isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] .  MCMS::dirname($_SERVER['PHP_SELF']),'/') . '/';
		$this->remote_path = defined('MCMS_REMOTE_PATH') ? CMS_REMOTE_PATH : $url;

		// Debug settings

		$this->log = defined('MCMS_LOG') ? MCMS_LOG : $this->local_path . 'system/logs/log.log';

		$this->debugging = defined('MCMS_DEBUG') ? MCMS_DEBUG : false;
		$this->debug_type = defined('MCMS_DEBUG_TYPE') ? MCMS_DEBUG_TYPE :  MCMS::dump_none;
		$this->debug_level = defined('MCMS_DEBUG_LEVEL') ? MCMS_DEBUG_LEVEL :  MCMS::dump_error; 
		$this->debug_default_level = defined('MCMS_DEBUG_DEFAULT_LEVEL') ? MCMS_DEBUG_DEFAULT_LEVEL : $this->debug_level;

		// Work out the path to resolve

		$this->path = defined('MCMS_PATH') ? MCMS_PATH : isset($_GET['path']) && trim($_GET['path'],'/') != '' ? trim($_GET['path'],'/') : 'home';

		// And the local system path

		$this->local_path = defined('MCMS_LOCAL_PATH') ? MCMS_LOCAL_PATH : (MCMS::dirname(__FILE__) . '/');

		$this->request = uniqid(time() . '.', true); // Psuedo uniqid request identifier

	}
	private function load($usePath = true) {
		$this->files('config','storage','site','package','module');
		try {
			$this->config = Config::Load();
		} catch (Config_Not_Found_Exception $e){
			throw new MCMS_Not_Installed_Exception($e);
			
		}	
		$this->storage = Storage::GetStorageSolution();
		$this->site = Site::Load();
		Package::Load_All();
		Module::Load_All();
		Module::Get('output');
		Module::Get('resource');
		if($usePath) {
			$paths = array($this->path, 'error');
		}
		else {
			$paths = array('error');
		}
		foreach($paths as $path){
			try {				
				$this->resource($path);
				return;
			} catch(Exception $e){
				$this->exceptions[] = $e;				
			}
		}
		throw new MCMS_Load_Resource_Exception($path, $exceptions);
	}
	public function run() {
		try{
			try {
				try {
					$this->load();
				} catch(MCMS_Not_Installed_Exception $e) {
					try {
						$this->install();
					} catch (Exception $f){
						throw new MCMS_Install_Exception(array($e, $f));
					}
				} catch(Exception $e){
					throw new MCMS_Load_Exception($e);
				}
				$this->output->render($this->logic->display());
			} catch (Exception $e) {
				$this->exceptions[] = $e;
				try {
					$this->load(false);
				} catch(MCMS_Not_Installed_Exception $e) {
					try {
						$this->install();
					} catch (Exception $f){
						throw new MCMS_Install_Exception(array($e, $f));
					}
				} catch(Exception $e){
					throw new MCMS_Load_Exception($e);
				}
				$this->output->render($this->logic->display());			
			}
		} catch (Exception $e) {
			$this->error($e,true);	 
		} 
	}
	public function dump($level, $exception, $debug){
		if($debug && ($level > $this->debug_level || !$this->debugging)){
			return;
		}
		switch($this->debug_type){
			case MCMS::dump_screen:
				if(!headers_sent()){
					header('Content-type: text/plain');
				}
				echo $exception->message()."\r\n";
				echo $exception."\r\n\r\n";
				break;
			case MCMS::dump_file:
				file_put_contents($this->local_path . 'system/logs/dump.' . $this->request . '.log', $exception->dump() . "\r\n", FILE_APPEND);
				break;
			case MCMS::dump_file_log:
				file_put_contents($this->local_path . 'system/logs/dump.log', $this->request . "\r\n" . $exception->dump() . "\r\n", FILE_APPEND);
				break;
			case MCMS::dump_log:
				file_put_contents($this->log, date('M j H:i:s') . ' mcms [' . $this->request . '] ' . $exception->message() . "\r\n", FILE_APPEND);
				break;
			case MCMS::dump_syslog:
				openlog("mcms", LOG_PID, LOG_USER);
				switch($this->level){
					case MCMS::dump_notice:
						$level = LOG_NOTICE;
						break;
					case MCMS::dump_warning:
						$level = LOG_WARNING;
						break;
					case MCMS::dump_error:
						$level = LOG_ERR;
						break;
					default:
						$level = LOG_INFO;
				}
				file_put_contents($this->log, syslog($level, $exception->message));
				closelog();
				break;
		}
		
	}	
	public function error($e, $fatal = false){
		if($fatal && !headers_sent()){ 
			 header("HTTP/1.1 500 Internal Server Error");
		}
		$this->dump(MCMS::dump_error, $e, false);
		if($fatal){
			exit;
		}

	}
	public function resource($path){
		$exceptions = array();
		try {
			$this->resources = Resource::Get_By_Path($path);
			foreach($this->resources as $resource){
				try {
					$this->formats = array();
					if(defined('CMS_FORMAT'))
						$this->formats[] = CMS_FORMAT;
					if(isset($_GET['output']))
						$this->formats[] = $_GET['output'];
					$this->formats[] = $resource->get_output();
					if(defined('CMS_FORMAT_DEFAULT'))
						$this->formats[] = CMS_FORMAT_DEFAULT;
						
					$this->output = Output::Load($this->formats);
					$this->logic = $this->output->logic($resource);
					return;
				} catch (Exception $e){
					$exceptions[] = $e;
				}
			}
		} catch (Exception $e){
			$exceptions[] = $e;
		}
		throw new MCMS_Resource_Exception($path,$exceptions);
		
	}
	public function storage() {
		return $this->storage;
	}
	public function site(){
		return $this->site;
	}
	public function output(){
		return $this->output;
	}
	public function config(){
		return $this->config;
	}
	public function files(){
		foreach(func_get_args() as $file){
			$this->file($file, true);	
		}
	}
	public function install(){
		// Install the system. Quite easy from this perspective!
		$this->file('install');		
		$this->output = $this->logic = Install::Load();
	}
	public function remote_path(){
		return $this->remote_path;
	}
	public function redirect($url){
		header('Location: ' . $url, 303);
		exit;
	}
	public function file($file, $once = true){
		$path = "{$this->local_path}{$file}.php";
		
		if(file_exists($path)){
			if($once){
				return require_once($path);
			} else {
				return require($path);
			}
		} else {
			throw new MCMS_File_Not_Found_Exception($file);
		}
		
	}	
	public function url($url, $get = array(), $internal = true){
		if($internal){		
			$url = rtrim($url, '/') . '/';
		}
		if(count($get) > 0){
			$gets = array();
			foreach($get as $k => $v){
				$gets[] = "{$k}={$v}";
			}
			$url .= '?' . implode('&', $gets);
		}
		return $this->remote_path . $url;
	}
	public function local_path($path = ''){
		return $this->local_path . $path;
	}
}