<?php

/**
 * Page API File
 *
 * Subversion ID: $Id$
**/

class Page extends API  {

  // Construct a Page object from data
  
  function __construct($data){
    $this->layout_type = 'page';
    foreach($data as $f => $v){
      $this->$f = $v;
    }    
  }
  
  // Load a page given a alias
  
  static function Get_By_Alias($alias){
    $sql = "SELECT * FROM page WHERE alias = %s";
    $result = Fusion::$_->storage->query($sql, $alias);
    if($result && $row = $result->fetch_assoc()){
      // Class
      if($row['type'] != ''){
        $c = 'Page_' . $row['type'];
      }
      if($row['type'] == '' || class_exists($c)){
        $c = 'Page';
      }
      
      $obj = new $c($row);
      return $obj;
    } 
    return false;
  }
  
  // Load the current page
  
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
      $page = Page::Get_By_Alias($alias);
      if($page){
        if($g == ''){
          $mode = '';
        } else {
          $mode = trim(substr($g, strlen($row['alias'])), '/');
        }
        if($page->authorised($mode)){
          Log::Message("Page " . $page->name . " loaded.");
          return $page;
        }
      }
    }
    Install::Page();
  }
  
  // Check permissions and select mode
  
  function authorised($mode){
    $ms = explode('/',$mode,2);
    
    // Permissions
    $modes = Fusion::$_->auth->permissions('page', $this->id, array('view','edit','layout'));
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
  
  // Create a URL to this page
  
  function URL($mode = ''){
    if($this->alias != ''){
      return Fusion::$_->url($this->alias . '/' . $mode);
    } else {
      return Fusion::$_->url($mode);
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
    $this->layout = Layout::Page($this->id, $this->layout);
    $this->layout->load_layout(true);
    $this->layout->run('view');
    return true;
  }
  
  function output_view(){
    // Create template and add blocks
    $template = Fusion::$_->output->template('page/view');
    $template->layout = $this->layout->output();
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
    $template->zone = $this->zone->output($this);
    return $template;
  }
  
}
