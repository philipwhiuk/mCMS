<?php

/**
 * Output API File
 *
 * Subversion ID: $Id$
**/

class Output {

  static function Load(){
    if(isset($_GET['output']) && class_exists('Output_' . $_GET['output'])){
      $c = 'Output_' . $_GET['output'];
      return new $c();
    }
    
    if(isset(Fusion::$_->config['output']) && class_exists('Output_' . Fusion::$_->config['output'])){
      $c = 'Output_' . Fusion::$_->config['output'];
      return new $c();
    }
    
    Install::Output();
  }

}
