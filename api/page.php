<?php

/**
 * Page API File
 *
 * Subversion ID: $Id$
**/

class Page {

  static function Load(){
    $aliasi = array();
    $g = '';
    if(isset($_GET['page'])){
      $g = $_GET['page'];
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
        
        if($g == ''){
          $mode = '';
        } else {
          $mode = trim(substr($g, strlen($row['alias'])), '/');
        }
        
        
        $obj = new $c($row);
        if($obj->authorised($mode)){
          return $obj;
        }
      }
    }
    Install::Page();
  }

  function __construct($data){
    foreach($data as $f => $v){
      $this->$f = $v;
    }    
  }
  
  function authorised($mode){
    $ms = explode('/',$mode,2);
    // Implement authorisation here.    
    $this->modes = array('view' => array(), 'edit' => array());
    
   // Localisation and links
    foreach($this->modes as $mode => &$data){
      $data['name'] = Fusion::$_->locale->get('Page/mode/' . $mode);
      $data['selected'] = false;
      $data['link'] = Fusion::URL($this->URL($mode));
    }
    
    // Mode selector
    if(isset($ms[0]) && isset($this->modes[strtolower($ms[0])])){
      $this->mode = strtolower($ms[0]);
      $this->remainder = $ms[1];
    } elseif(isset($this->modes['view'])){
      $this->mode = 'view';
      $this->remainder = $mode;
    } else {
      return false;
    }
    
    $this->modes[$this->mode]['selected'] = true;
    
    return true;
  }
  
  // API
  
  
  function URL($mode = ''){
    if($this->alias != ''){
      return Fusion::$_->config['root'] . $this->alias . '/' . $mode;
    } else {
      return Fusion::$_->config['root'] . $mode;
    }
  }
  
  // Main operations
  
  function run(){
    $m = 'run_' . $this->mode;
    return $this->$m($this->remainder);
  }
  
  function output(){
    $m = 'output_' . $this->mode;
    $template = $this->$m();
    $template->modes = $this->modes;
    return $template;
  }
  
  // View operations
  
  function run_view(){
    $this->zone = Zone::Load($this->template);
    $this->zone->run($this, $this->remainder, true);
    return true;
  }
  
  function output_view(){
    // Create template and add blocks
    $template = Fusion::$_->output->template('page/view');
    $template->zone = $this->zone->output();
    return $template;
  }
  
  // Edit operations
  
  function run_edit(){
    $this->zone = Zone::Load($this->template);
    $this->zone->run($this, $this->remainder, false);
    return true;
  }
  
  function output_edit(){
    // Create template and add blocks
    $template = Fusion::$_->output->template('page/edit');
    $template->zone = $this->zone->output();
    return $template;
  }

}
