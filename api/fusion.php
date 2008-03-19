<?php

/**
 * Fusion Class File
 *
 * This file contains the Fusion Class file which contains the root class of the Fusion system. 
 * This class controls the rest of the system.
 * @version $Id:$
 * @package Fusion
 * @subpackage API
**/

/**
 * Fusion
 *
 * Fusion is the root class of the Web Framework.
 * It loads and controls all the APIs which in turn generate the pages.
 *
 * Its operation can be extended through APIs which can 'hook' into the current execution sequence.
 *
 * The root class can be accessed by any API using: Fusion::$_
 *
 * @package Fusion
 * @subpackage API
 * @see index.php
**/

class Fusion {

/**
 * Root Variable
 *
 * This static variable contains a reference to the current Fusion object is initalised on construction.
 * 
 * It can be acessed anytime after construction has started.
 *
 * @var Reference to root Fusion class
 **/
    static $_; 
  
/**
 * APIs
 *
 * Lists all the APIs in current use, along with the parameters returned when they were constructed.
 *
 * @var array List of APIs.
**/
    var $api = array();
    
/**
 * Configuration
 *
 * Contains the current configuration in a key => value form.
 *
 * Loaded by the Config API and controlled by the Config API.
 *
 * @var array Array containing global configuration values in key => value form.
 * @see Config
**/
    var $config;
   
/**
 * Log
 *
 * Contains the current logger
 *
 * @var Log Current log object.
 * @see Log
**/
    var $log;
    
/**
 * Storage
 *
 * Contains the current storage mechanism which controls data access and alteration.
 *
 * @var object This contains a object of a class that implements the storage operations found in the mysqli class.
**/
    var $storage;
  
/**
 * Authentication
 *
 * Contains the current authentication object to handle authentication and authorisation.
 *
 * @var Authentication The current authentication object
**/
  var $auth;
  
/**
 * Constructor
 *
 * The constructor scans the API directory, and then proceeds to load any file which has a single extension which is 'php'.
 *
 * It then calls the Fusion::api_load function on each one to initalise the Fusion::$api array
 *
 * Finally it calls the 'fusion_construct' hook.
 *
 * @uses Fusion::$api
 * @uses Fusion::api_load()
 * @uses Fusion::api_call()
 **/
  
    function __construct(){
      // Load APIs
      Fusion::$_ = $this;
      $files = scandir(FUSION . '/api/');
      foreach($files as $file){
        $f = explode('.', $file, 2);
        if(is_file(FUSION . '/api/' . $file) && isset($f[1]) && $f[1] == 'php'){
          require_once(FUSION . '/api/' . $file);
          $this->api[$f[0]] = $this->api_load($f[0]);
        }
      }
      $this->api_call('fusion_construct');
    }
    
/**
 * Load
 *
 * The load function begins the initalisation process, that only needs to be called once on each page load.
 *
 * First it loads a new Log, then it loads the file based configuration.
 * It then loads the storage mechanism, and then it loads the storage based configuration.
 *
 * Finally it calls the 'fusion_load' hook.
 *
 * @uses Log
 * @uses Config::File()
 * @uses Storage::Load()
 * @uses Config::Storage()
 * @uses Fusion::$log
 * @uses Fusion::$config
 * @uses Fusion::$storage
 * @uses Fusion::api_call()
 **/
    
    function load(){
      $this->log = new Log();
      $this->config = Config::File();
      $this->storage = Storage::Load();
      Config::Storage();
      $this->auth = Authentication::Load();
      $this->api_call('fusion_load');
    }
    
/**
 * Personalise
 *
 * This function loads all the user dependant information, such as the User object and the Locale object.
 *
 * This function may be called again if the user changes half way through (after authentiction for example).
 *
 * Finally it calls the 'fusion_personalise' hook.
 * This hook should be used where User dependant data needs to be loaded.
 *
 * @uses Authentication::Load()
 * @uses User::Load()
 * @uses Locale::Load()
 * @uses Fusion::$auth
 * @uses Fusion::$user
 * @uses Fusion::$locale
 * @uses Fusion::api_call()
 **/
    
    function personalise(){
      $this->user = User::Load();
      $this->locale = Locale::Load();
      $this->api_call('fusion_personalise');
    }
    
/**
 * Run
 *
 * This function runs the Web Framework, executing all the logic code and generating the data to be displayed.
 *
 * Finally it calls the 'fusion_run' hook. This should be used where post generation alteration needs to be done by an API.
 *
 * @uses Page::Load()
 * @uses Page::run()
 * @uses Fusion::$page
 * @uses Fusion::api_call()
 **/
    
    function run(){
      $this->page = Page::Load();
      $result = $this->page->run();
      $this->api_call('fusion_run');
      return $result;
    }
    
/**
 * Output
 *
 * This function loads the output component, and executes any output based logic (such as selecting a theme) and then sends the page to output.
 *
 * Then it calls the 'fusion_output' hook. This hook allows any post output work to be done by a API.
 *
 * @uses Output::Load()
 * @uses Output::run()
 * @uses Output::output()
 * @uses Page::output()
 * @uses Fusion::$page
 * @uses Fusion::$output
 * @uses Fusion::api_call()
 **/
    
    function output(){
      $this->output = Output::Load();
      $this->output->run();
      $this->output->output($this->page->output());
      $this->api_call('fusion_output');
    }
    
/**
 * URL Generation
 *
 * This function creates a system relative url to the resources requested.
 *
 * It prepends the root of the system aquired from the global configuration data.
 *
 * @uses Fusion::$config
 **/
  
    function url($url){
      return $this->config['root'] . $url;
    }
    
/**
 * API Load
 *
 * This function loads the requested API and returns any results for the Fusion::$api array.
 *
 * It firsts looks for a class with the same name as the API, then if it finds one, and the method API::Load_API exists, then it executes it returning any results.
 *
 **/
  
    function api_load($name){
      if(class_exists($name) && method_exists($name, 'load_api')){
        return call_user_func(array($name, 'load_api'));
      }
    }
    
/**
 * API Call
 *
 * This function looks at each API in turn and if it set to respond to the named hook, then the function named is executed.
 *
 * This function gets passed a list of arguments. These are first the arguments it was requested, then the arguments passed to the hook.
 *
 * If a API wishes to respond to a hook, the following must be in place:
 * 
 * Fusion::$_->api[api_name]['call'][hook_name] = array('func' => function_to_be_called, 'args' => array_of_arguments_to_pass)
 *
 * This is easiest to set in the APIs Load_API method
 *
 * @uses Fusion::$api
 * @see Fusion::api_load()
 *
 **/
    
    function api_call($name){
      $args = func_get_args();
      foreach($this->api as $n => $data){
        if(isset($data['call'][$name])){
          call_user_func($data['call'][$name]['func'], array_merge((isset($data['call'][$name]['args']) ? ((array) $data['call'][$name]['args']) : array()), $args));
        }
      }
    }
}

/**
 * API
 *
 * This is the base class of all the APIs used by the system. This allows for backwards compatability to be implemented in the future.
 *
 * @package Fusion
 * @subpackage API
 * @see Fusion
**/

class API {

}
