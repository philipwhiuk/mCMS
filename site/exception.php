<?php

/**
 * Indicates an exception thrown by the Site Module.
 */
class Site_Exception extends MCMS_Exception {}
/**
 * Indicates an configuration error relating to the Site Module.
 */
class Site_Configuration_Exception extends Site_Exception {}
/**
 * Indicates the given site was not found.
 */
class Site_Not_Found_Exception extends Site_Exception {}
/**
 * Indicates there were multiple applicable sites.
 */
class Site_Not_Unique_Exception extends Site_Exception {}
/**
 * Indicates the given key relating to the site was not found.
 */
class Site_Key_Not_Found_Exception extends Site_Exception {}