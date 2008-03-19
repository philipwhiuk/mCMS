<?php
/**
 * Index File
 *
 * This file starts off the Fusion Web Framework, loads essential files and loads the Fusion class.
 * It is also reponsible for all the built-in helper functions such as the class autoloader and error handling.
 * @version $Id$
 * @package Fusion
**/

/**
 * Fusion Directory
 *
 * This definition holds the location of the Fusion root. It allows the non web accessible files (ie everything apart from theme) to be moved to another place.
**/

define('FUSION', '.');

/**
 * Autoload
 *
 * This function resolves class dependacies automatically to allow for the APIs to be loaded in any order that is desired. It simply loads the API of the same name.
**/

  function __autoload($class){
    if(is_file(FUSION . '/api/' . $class . '.php')){
/**
 * Fusion Class
 *
 * This simply loads the needed class file if it exists.
 *
**/
      require_once(FUSION . '/api/' . $class . '.php');
    }
  }
  
/**
 * Error Handler
 *
 * This function looks whether the Debugging settings are on.
 *
 * If they are, it invokes the Krumo debugger and dumps all relevant data.
 *
 * If not it exists.
 *
 * In any case, it will log a message.
 *
**/
  
  function __error($message = ''){
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
  
/**
 * Fusion Class
 *
 * This simply loads the Fusion class in the API folder.
 *
**/

require_once(FUSION . '/api/fusion.php');
Fusion::$_ = new Fusion;
Fusion::$_->load();
Fusion::$_->personalise();
if(Fusion::$_->run()){
	Fusion::$_->output();
}
