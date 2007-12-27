<?php

/**
 * Zone API File
 *
 * Subversion ID: $Id: page.php 16 2007-12-26 19:47:06Z agentscorpion $
**/

class Zone {

  function __construct($data){
    $this->zones = array();
    $this->width = 100;
    foreach($data as $f => $v){ $this->$f = $v; }
  }
  
  function run(Page $page, $remainder){
    if(!$this->ran){
      $this->ran = true;
      $this->blocks = Block::Load($this->id, $page, $remainder);
      foreach($this->blocks as $b => &$row){
        foreach($row as $c => &$block){
          $block->run();
        }
      }
      foreach($this->zones as $r => &$row){
        foreach($row as $c => &$col){
          foreach($col as $z => &$zone){
            $zone->run($page, $remainder);
          }
        }
      }
    }
  }

  function output(){
    $template = Fusion::$_->output->template('zone/view');
    $template->zones = array();
    foreach($this->zones as $r => &$row){
      foreach($row as $c => &$col){
        foreach($col as $z => &$zone){
          $template->zones[$r][$c][$z] = $zone->output();
        }
      }
      ksort($template->zones[$r]);
    }
    ksort($template->zones);
    $template->blocks = array();
    foreach($this->blocks as $r => &$row){
      foreach($row as $b => &$block){
        $template->blocks[$r][$b] = $block->output();
      }
      ksort($template->blocks[$r]);
    }
    $template->width = $this->width;
    $template->row = $this->row;
    return $template;
  }

  static function Load($template){
    $zones = array(0 => new Zone(array()));
    $sql = "SELECT * FROM page_template_zone WHERE template = %u";
    $result = Fusion::$_->storage->query($sql, $template);
    if($result){
      while($row = $result->fetch_assoc()){
        $zones[$row['id']] = new Zone($row);
      }
    }
    foreach($zones as $z => &$zone){
      if($z != 0){
        if(isset($zones[$zone->parent])){
          $zones[$zone->parent]->zones[$zone->row][$zone->sort][$zone->id] = $zone;
        } else {
          // Error
          $zones[0]->zones[99][][$zone->id] = $zone;
        }
      }
    }
    return $zones[0];  
  }


}
