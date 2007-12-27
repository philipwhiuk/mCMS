<?php

/**
 * Locale API File
 *
 * Subversion ID: $Id$
**/

// This file controles localisation

class Locale {

  function __construct($data){
    foreach($data as $f => $v){
      $this->$f = $v;
    }
    $this->strings = array();
  }

  static function Load(){
    $sql = "SELECT * FROM locale WHERE id = %u";
    $result = Fusion::$_->storage->query($sql, Fusion::$_->user->locale);
    if($result && $row = $result->fetch_assoc()){
      $c = 'Locale_' . $row['type'];
      Log::Message("{$row['name']} ({$row['type']}) locale loaded.");
      return new $c($row);
    }
    Install::Locale();
  }
  
  function Get($translate){
    return $translate;
  }

}

class Locale_File extends Locale {

  function Get($translate){
    if(isset($this->strings[$translate])){
      return $this->strings[$translate];
    }
    $locations = array('default');
    $c = explode('/',$translate);
    $e = '';
    foreach($c as $d){
      $locations[] = $e . $d;
      $e .= $d . '/';
    }
    
    $locations = array_reverse($locations, true);
    
    $f = explode('-', $this->name);
    $e = '';
    $folders = array();
    foreach($f as $n){
      $folders[] = $e . $n;
      $e .= $n . '-';
    }
    
    $folders = array_reverse($folders, true);
    
    foreach($folders as $folder){
      foreach($locations as $location){
        if(file_exists('locale/' . $folder . '/' . $location . '.php')){
          require_once('locale/' . $folder . '/' . $location . '.php');
          if(isset($this->strings[$translate])){
            return $this->strings[$translate];
          }
        }
      }
    }
    return $translate;
  
  }


}
