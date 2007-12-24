<?php

/**
 * Page API File
 *
 * Subversion ID: $Id$
**/

class Page {

  function authorised(){
    // Implement
    return true;
  }

  function __construct($data){
    foreach($data as $f => $v){
      $this->$f = $v;
    }
  }
  
  function load_blocks(){
    $this->blocks = array();
    $sql = "SELECT * FROM page_block LEFT JOIN block ON page_block.block_id = block.id WHERE page_id = %u";
    $result = Fusion::$_->storage->query($sql, $alias);
    if($result){
      while($row = $result->fetch_assoc()){
        $c = 'Block_' . $row['type'];
        $obj = new $c($row);
        if($obj->authorised()){
          $this->blocks[$row['id']] = $obj;
        }
      }
    }
  }
  
  function run(){
    $this->load_blocks();
    foreach($this->blocks as $block){
      $block->run();
    }
    return true;
  }

  static function Load(){
    $aliasi = array();
    if(isset($_GET['page'])){
      $s = explode('/', $_GET['page']);
      $t = '';
      foreach($s as $p){
        $aliasi[] = $t . $p;
        $t = $t . $p . '/';
      }
      $aliasi = array_reverse($aliasi);
    }
    $aliasi[] = '';
    foreach($aliasi as $alias){
      $sql = "SELECT * FROM page WHERE alias = %s";
      $result = Fusion::$_->storage->query($sql, $alias);
      if($result && $row = $result->fetch_assoc()){
        if($row['type'] !== ''){
          $c = 'Page_' . $row['type'];
        } else {
          $c = 'Page';
        }
        Log::Message("{$row['name']} ({$row['type']}) page loaded.");
        $obj = new $c($row);
        if($obj->authorised()){
          return $obj;
        }
      }
    }
    Install::Page();
  }

}
