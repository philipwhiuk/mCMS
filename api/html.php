<?php

/**
 * HTML API File
 *
 * Subversion ID: $Id$
**/

class Output_HTML extends Output {

  function Run(){
    // Load Theme
    $sql = "SELECT * FROM theme WHERE id = %u";
    $result = Fusion::$_->storage->query($sql, Fusion::$_->user->theme);
    if($result && $row = $result->fetch_assoc()){
      if($row['type'] !== ''){
        $c = 'Theme_' . $row['type'];
      } else {
        $c = 'Theme';
      }
      $this->theme = new $c($row);
    }
  }
  
  function Output($template){
    
  }

}

