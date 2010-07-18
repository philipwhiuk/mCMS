<?php
/**
 * Index File
 * 
 * This is the default entry point for the CMS.
 * 
 * This file simply allows very basic configuration of the system to be completed - or for intergration within a larger system.
 * 
 * @package CMS
 */

/**
 * Valid Entry Point
 * 
 * This is simply used to verify that the user has entered the system at a valid entry point, in case the entire system is web accessible.
 * 
 * @var boolean
 */

define('CMS',true);

/**
 * Loads the CMS file.
 * 
 * This loads the main CMS system as {@link CMS::File()} is not available yet.
 * 
 * @see cms.php
 * 
 */
		
require_once(rtrim(str_replace('\\', '/', dirname(__FILE__)),'/') . '/system.php');


/**
 * Include Local Edits
 **/

if(file_exists(System::dirname(__FILE__) . '/index.local.php')){
  require_once(System::dirname(__FILE__) . '/index.local.php');
}

System::Get_Instance()->run();
