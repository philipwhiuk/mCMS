<?php

/**
 * Block Management Class File
 *
 * This file contains the Block class which allows blocks to be represented across the system.
 * @version $Id:$
 * @package Fusion
 * @subpackage API
**/

/**
 * Block
 *
 * The block class represents the blocks which are displayed on pages. These show the content in the system to the user and control its retrieval, update and viewing.
 * It is responsible for managing the blocks and for delegating functions to sub classes.
 *
 * To make a new block, simply derive a new class from this one.
 *
 * @package Fusion
 * @subpackage API
**/

class Block extends API  {

  static function Load($zone, Page $page, $remainder){
    $blocks = array(); 
    $sql = "SELECT * FROM page_template_blocks WHERE zone = %d";
    $result = Fusion::$_->storage->query($sql, $zone);
    if($result){
      while($row = $result->fetch_assoc()){
        $c = 'Block_' . $row['type'];
        if(class_exists($c)){
          $blocks[$row['sort']][$row['id']] = new $c($row, $page);
          if(!$blocks[$row['sort']][$row['id']]->authorised($remainder)){
            unset($blocks[$row['sort']][$row['id']]);
          }
        }
        
      }
    }
    return $blocks;
  }
  
  static function Create($data){
    $sqls = array();
    foreach($data as $k => $v){
      $sqls[] = " $k = %s ";
    }
    $sql = "INSERT INTO page_template_blocks SET " . join($sqls, ' , ');
    return ($result = Fusion::$_->storage->query($sql, $data));
  }

  function __construct($data, Page $page){
    foreach($data as $f => $v){ $this->$f = $v; }
    $this->page = $page;
  }

  function URL($mode = 'view'){
    return $this->page->URL() . $this->id . '/' . $mode;
  }

  function authorised($mode = ''){
    $ms = explode('/',$mode,3);
    
    // Implement authorisation here.    
    $this->modes = array('view' => array(), 'edit' => array());
    
    // Localisation and links
    foreach($this->modes as $mode => &$data){
      $data['name'] = Fusion::$_->locale->get(str_replace('Block_','',get_class($this)) . '/mode/' . $mode);
      $data['selected'] = false;
      $data['link'] = Fusion::URL($this->URL($mode));
    }
    
    // Mode selector
    if(isset($ms[1]) && $ms[0] === $this->id && isset($this->modes[strtolower($ms[1])])){
      $this->mode = strtolower($ms[1]);
      $this->remainder = isset($ms[2]) ? $ms[2] : '';
    } elseif(isset($this->modes['view'])){
      $this->mode = 'view';
      $this->remainder = $mode;
    } else {
      return false;
    }
    
    $this->modes[$this->mode]['selected'] = true;
    
    return true;
  }  
  
  function run($render){
  
  }
  
  function output(){
    return new Template;
  }

}
