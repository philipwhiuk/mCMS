<?php
/**
 * Indicates an exception with the Storage module.
 */
class Storage_Exception extends MCMS_Exception {}
/**
 * Indicates a configuration error relating to the Storage module.
 */
class Storage_Configuration_Exception extends Storage_Exception {}
/**
 * Indicates a storage driver was not found.
 */
class Storage_Driver_Not_Found_Exception extends Storage_Exception {}
/**
 * Indicates a storage driver was invalid.
 */
class Storage_Driver_Invalid_Exception extends Storage_Exception {}