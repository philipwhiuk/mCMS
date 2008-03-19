<?php

class Layout extends API  {

  var $blocks = array();
  var $zones = array();

  function __construct($data = array()){
    foreach($data as $row => $value){
      $this->$row = $value;
    }
  }
  
  static function Page($id, $parent, $recurse = true){
    $layout = new Layout();
    $layout->id = -$id;
    $layout->parent = $parent;
    if($recurse && $layout->parent != 0){
      $layout->playout = Layout::Get($parent, true);
    }
    return $layout;
  }

  static function Get($id, $recurse = true){
    $sql = "SELECT * FROM layout WHERE layout = %u";
    $result = Fusion::$_->storage->query($sql, $id);
    if($result && $row = $result->fetch_assoc()){
      $layout = new Layout($row);
    }
    if($recurse && $layout->parent != 0){
      $layout->playout = Layout::Get($parent, true);
    }
    return $layout;
  }
  
  function load_layout(){
    
    // Previous
    
    if(isset($this->playout)){
      $this->zones = $this->playout->zones;
      $this->blocks = $this->playout->blocks;
    } else {
      $this->zones = array();
      $this->blocks = array();
    }
    
    // Load the zones
    
    $sql = "SELECT * FROM zone WHERE layout = %d";
    $result = Fusion::$_->storage->query($sql, $this->id);
    if($result){ 
      while($row = $result->fetch_assoc()){
        if(isset($this->zones[$row['parent']]) || $row['parent'] == 0){
          $this->zones[$row['id']] = new Zone($row);
        }
      }
    }
    
    // Load the blocks
    
    $sql = "SELECT * FROM block WHERE layout = %d";
    $result = Fusion::$_->storage->query($sql, $this->id);
    if($result){ 
      while($row = $result->fetch_assoc()){
        if(isset($this->zones[$row['zone']]) && !$this->zones[$row['zone']]['locked']){
          if(class_exists('Block_' . $row['type'])){
            $c = 'Block_' . $row['type'];
            $this->blocks[$row['id']] = new $c($row);
          } else {
            $this->blocks[$row['id']] = new Block($row);
          }
        }
      }
    }
    
    // Load the Zone Locks
    
    $sql = "SELECT * FROM pagelayout_zone WHERE plid = %d";
    $result = Fusion::$_->storage->query($sql, $this->id);
    if($result){
      while($row = $result->fetch_assoc()){
        if(isset($this->zones[$row['zid']])){
          $this->zones[$row['zid']]->locked = true;
        }
      }
    }
    
    // Load the Block Data
    
    $sql = "SELECT * FROM pagelayout_block WHERE plid = %d";
    $result = Fusion::$_->storage->query($sql, $this->id);
    if($result){
      while($row = $result->fetch_assoc()){
        if(isset($this->blocks[$row['bid']]) && !isset($this->blocks[$row['bid']]->data)){
         $this->blocks[$row['bid']]->data = $row['data'];
        }
      }
    }
  }
  
  function authorised($mode){
    $ms = explode('/',$mode,2);
    
    // Permissions
    $modes = Fusion::$_->auth->permissions('layout', $this->id, array('view','edit'));
    $this->modes = array();
    foreach($modes as $m){
      $this->modes[$m] = array();
    }
    
    
   // Localisation and links
    foreach($this->modes as $cmode => &$data){
      $data['name'] = Fusion::$_->locale->get('Page/mode/' . $cmode);
      $data['selected'] = false;
      $data['link'] = $this->URL($cmode);
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
  
  function run($mode){ // Sort out modes later
    $this->mode = $mode;
    $this->layout = array();
    foreach($this->blocks as $b => $block){
      $this->zones[$block->zone]->blocks[$block->row][] = $block;
    }
    foreach($this->zones as $z => $zone){
      if($zone->parent == 0){
        $this->layout[] = $zone;
      } else {
        $this->zones[$zone->parent][$zone->row][$zone->col][] = $zone;
      }
    }
    foreach($this->layout as $z => $zone){
      $this->layout[$z]->run();
    }
  }
  
  function output(){
    $m = 'output_' . $this->mode;
    $template = $this->$m();
    $template->modes = isset($this->modes) ? $this->modes : array();
    return $template;
  }
  
  function output_view(){
    $template = Fusion::$_->output->template('layout/view');
    $template->layout = array();
    foreach($this->layout as $z => $zone){
      $template->layout[$z] = $this->layout[$z]->output();
    }
    return $template;
  }
  
}
