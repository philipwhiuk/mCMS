<?php

header('Content-type: text/plain');

ini_set('display_errors', 1); 

/**
 * System Class File
 * 
 * This contains the core System class.
 * 
 * @package CMS
 */

// Stricts suck in most PHP versions!

error_reporting(error_reporting() & ~E_STRICT);


/**
 * Load exceptions
 * 
 * This loads the exceptions for the System class.
 * 
 * @see system/exception.php
 * 
 */

require_once(dirname(__FILE__) . '/system/exception.php');

/**
 * System
 * 
 * This class is a singleton and represents the running CMS.
 * 
 * It is at the top of what is currently running, and is the central point of execution.
 * 
 * @package CMS
 *
 */

class System {
	
	/**
	 * Instance Variable
	 * 
	 * This is used to create the singleton - this holds the one and only instance.
	 * 
	 * @var System System instance
	 */
	
	// Main Variables
	
	private $logic;
	private $output;
	
	// Singleton
	
	private static $instance = null;
	
	// Configuration
	
	private $log;
	private $debug_type;
	public $debug_default_level;
	private $debug_level;
	private $local_path;
	private $remote_path;
	private $path;
	private $formats;
	
	// Core Systems
	
	private $database;
	private $config;
	private $site;
	
	// Modules
	
	public $modules;
	
	// Dirname (Windows compatible) 
	
	private function dirname($file){
		$string = dirname($file);
		return rtrim(str_replace('\\', '/', $string),'/');
	}

        const dump_notice = 2;
        const dump_warning = 1;
        const dump_error = 0;
	    
        const dump_screen = 0;
        const dump_file = 1;
	const dump_file_log = 2;
	const dump_log = 3;
	const dump_syslog = 4;
	const dump_none = 5;
	
	/**
	 * Constructor
	 * 
	 * This a private constructor as it is a singleton and thus unable to be consturcted - except via {@link System::GetInstance()}.
	 * 
	 * This sets up {@link System::$debug} and {@link System::$local_path}
	 * 
	 */
	
	private function __construct(){
		
		// Okay, we need to create a new System
	
		// Use a full url as a default (probably Apache specific)

		$url = rtrim((isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']),'/') . '/';
		$this->remote_path = defined('CMS_REMOTE_PATH') ? CMS_REMOTE_PATH : $url;

		// Debug settings

		$this->log = defined('CMS_LOG') ? CMS_LOG : $this->local_path . 'system/logs/log.log';

		$this->debugging = defined('CMS_DEBUG') ? CMS_DEBUG : false;
		$this->debug_type = defined('CMS_DEBUG_TYPE') ? CMS_DEBUG_TYPE : System::dump_none;
		$this->debug_level = defined('CMS_DEBUG_LEVEL') ? CMS_DEBUG_LEVEL : System::dump_error; 
		$this->debug_default_level = defined('CMS_DEBUG_DEFAULT_LEVEL') ? CMS_DEBUG_DEFAULT_LEVEL : $this->debug_level;

		// Work out the path to resolve

		$this->path = defined('CMS_PATH') ? CMS_PATH : isset($_GET['path']) && trim($_GET['path'],'/') != '' ? trim($_GET['path'],'/') : 'home';

		// And the local system path

		$this->local_path = defined('CMS_LOCAL_PATH') ? CMS_LOCAL_PATH : (dirname(__FILE__) . '/');

		$this->request = uniqid(time() . '.', true); // Psuedo uniqid request identifier

	}
	
	/**
	 * Get Instance of System
	 * 
	 * Returns the current instance of the System. If there is not one available, it constructs one.
	 * 
	 * @return System
	 */
	
	public static function Get_Instance(){
		
		// Singleton
		
		if(!isset(System::$instance)){
			System::$instance = new System();	
		}
		
		return System::$instance;
		
	}
	
	/**
	 * Load Files
	 * 
	 * 
	 * @uses System::files() to load the given paths.
	 * @param string $file,... Any number of strings containing paths to files to load
	 */
	
	public function files(){
		foreach(func_get_args() as $file){
			$this->file($file, true);	
		}
	}
	
	/**
	 * Load a file
	 * 
	 * Loads a PHP file given a path relative to the local path.
	 * 
	 * @uses System::$local_path
	 * @param string $file File to be loaded
	 * @param boolean $once Ensure file is only included once?
	 * @throws System_File_Not_Found_Exception
	 */
	
	public function file($file, $once = true){
		
		$path = "{$this->local_path}{$file}.php";
		
		if(file_exists($path)){
			if($once){
				return require_once($path);
			} else {
				return require($path);
			}
		} else {
			throw new System_File_Not_Found_Exception($file);
		}
		
	}
	
	/**
	 * Install CMS
	 * 
	 * This allows the CMS to be installed.
	 * 
	 * @uses System::File()
	 * @uses Install::Load()
	 * @return unknown_type
	 */
	
	
	public function install(){

		// Install the system. Quite easy from this perspective!
		
		$this->file('install');
		
		$this->output = $this->logic = Install::Load();
		
		
	}
	
	/**
	 * Load's the CMS
	 * 
	 * Loads all the key files required to operate the system:
	 *  ({@link config.php}, {@link database.php}, {@link site.php}, {@link module.php}, {@link resource.php}, {@link page.php})
	 *  
	 * Then it loads the configuration. If this is can not be found then it throws an exception as the system hasn't be installed. 
	 * 
	 * It then loads the database, and site, and modules. before taking the current path and loading the relevant resource and pag
	 * 
	 * @uses System::file()
	 * @uses Config_Not_Found_Exception
	 * @uses Config::Load()
	 * @uses Database::Load()
	 * @uses Site::Load()
	 * @uses Module::Load()
	 * @uses Page::Load()
	 * @uses Resource::Load()
	 * @uses System_Install_Exception
	 * @uses System::$path
	 * @return unknown_type
	 */
	
	public function load(){

		// Okay this is the default load option
		
		// Lets load the base system.
		
		$this->files('config','database','site','module');
	
		try {

			$this->config = Config::Load();
			
		} catch (Config_Not_Found_Exception $e){

			throw new System_Not_Installed_Exception($e);
			
		}

		$this->database = Database::Load();
		$this->site = Site::Load();
		/*$this->modules = */ Module::Load_All();
		
		// Ensure core modules are loaded.
		
		Module::Get('output');
		Module::Get('resource');
		
		// Resource(s)

		$exceptions = array();
		
		$paths = array($this->path, 'error');

		foreach($paths as $path){
			try {
				$this->resource($path);
				return;
			} catch(Exception $e){
				$exceptions[] = $e;
			}
		}

		throw new System_Load_Resource_Exception($paths, $exceptions);
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
		
		throw new System_Resource_Exception($path,$exceptions);
		
	}

	public function dump($level, $exception, $debug){

		if($debug && ($level > $this->debug_level || !$this->debugging)){
			return;
		}

		switch($this->debug_type){
			case System::dump_screen:
				if(!headers_sent()){
					header('Content-type: text/plain');
				}
				echo $exception;
				break;
			case System::dump_file:
				file_put_contents($this->local_path . 'system/logs/dump.' . $this->request . '.log', $exception->dump() . "\r\n", FILE_APPEND);
				break;
			case System::dump_file_log:
				file_put_contents($this->local_path . 'system/logs/dump.log', $this->request . "\r\n" . $exception->dump() . "\r\n", FILE_APPEND);
				break;
			case System::dump_log:
				file_put_contents($this->log, date('M j H:i:s') . ' fusion [' . $this->request . '] ' . $exception->message() . "\r\n", FILE_APPEND);
				break;
			case System::dump_syslog:
				openlog("fusion-web", LOG_PID, LOG_USER);
				switch($this->level){
					case System::dump_notice:
						$level = LOG_NOTICE;
						break;
					case System::dump_warning:
						$level = LOG_WARNING;
						break;
					case System::dump_error:
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

		$this->dump(System::dump_error, $e, false);
		if($fatal){
			exit;
		}

	}
	
	public function run(){
		
		try {
			try {
				$this->load();
			} catch(System_Not_Installed_Exception $e){
				try {
					$this->install();
				} catch (Exception $f){
					throw new System_Install_Exception(array($e, $f));
				}
			} catch(Exception $e){
				throw new System_Load_Exception($e);
			}
			
			$this->output->render($this->logic->display());
			
			
		} catch (Exception $e) {
			$this->error($e,true);	 
		}
		
	}
	
	public function get_remote_path(){
		return $this->remote_path;
	}
	
	public function config(){
		return $this->config;
	}
	
	public function database(){
		return $this->database;
	}
	
	public function site(){
		return $this->site;
	}
	
	public function output(){
		return $this->output;
	}
	
	public function redirect($url){
		header('Location: ' . $url, 303);
		exit;
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

