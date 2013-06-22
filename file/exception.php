<?php
/**
 * An exception relating to the File module.
 */
class File_Exception extends MCMS_Exception {}

/**
 * Indicates the given file was not found.
 */
class File_Not_Found_Exception extends File_Exception {}

/**
 * An exception with page controlled by the File module.
 */
class File_Page_Exception extends File_Exception {}

/**
 * Indicates the given page was unavailable.
 */
class File_Page_Unavailable_Exception extends File_Page_Exception {}