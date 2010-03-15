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
 * Debugging
 * 
 * This sets up the level of debugging in the system. This is used by {@link CMS::$debug} to set the runtime debugging level.
 * 
 * @var int Debug level.
 */

define('CMS_DEBUG_TYPE',2);
define('CMS_DEBUG_DEFAULT_LEVEL',1);
define('CMS_DEBUG_LEVEL',1);

/**
 * Loads the CMS file.
 * 
 * This loads the main CMS system as {@link CMS::File()} is not available yet.
 * 
 * @see cms.php
 * 
 */

require_once(dirname(__FILE__) . '/system.php');

System::Get_Instance()->run();
