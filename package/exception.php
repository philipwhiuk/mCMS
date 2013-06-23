<?php
/**
 * Indicates an exception relating to Package management
 */
class Package_Exception extends MCMS_Exception {}
/**
 * Indicates the given package is not available.
 */
class Package_Not_Available_Exception extends Package_Exception {}