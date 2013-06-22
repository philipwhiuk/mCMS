<?php
/**
 * Indicates an exception thrown by the Admin module
 */
class Admin_Exception extends MCMS_Exception {}
/**
 * Indicates part of the administration functionality is invalid.
 */
class Admin_Invalid_Exception extends Admin_Exception {}
/**
 * Indicates one or more Admin Panels are unavailable
 */
class Admin_Panels_Unavailable_Exception extends Admin_Exception {}
/**
 * Indicates the given main page is unavailable.
 */
class Admin_Page_Main_Unavailable_Exception extends Admin_Exception {}
