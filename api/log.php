<?php

/**
 * Log File
 *
 * Subversion ID: $Id$
**/

class Log {

  static function Message($string){
    Fusion::$_->log[] = array(time(), $string);
  }

  static function Open(){
    return array(array(time(), 'Log Started'));
  }

}
