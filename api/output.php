<?php

/**
 * Output API File
 *
 * Subversion ID: $Id$
**/

class Output {

  function __construct($name){
    $this->name = $name;
  }

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

  function Template($name){
    $s = 'themes/' . $this->theme->folder . '/' . $this->name . '/' . $name . '.php';
    $c = 'Template_' . $this->theme->folder . '_' . $this->name . '_' . str_replace('/','_',$name);
    if(file_exists($s)){
      require_once($s);
      if(class_exists($c)){
        return new $c;
      }
    }
    return new Template;
  }

  static function Load(){
    if(isset($_GET['output']) && class_exists('Output_' . $_GET['output'])){
      $c = 'Output_' . $_GET['output'];
      return new $c($_GET['output']);
    }
    
    if(isset(Fusion::$_->config['output']) && class_exists('Output_' . Fusion::$_->config['output'])){
      $c = 'Output_' . Fusion::$_->config['output'];
      return new $c(Fusion::$_->config['output']);
    }
    
    Install::Output();
  }

}

class Template {

}
