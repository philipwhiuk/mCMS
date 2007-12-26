<?php

/**
 * HTML API File
 *
 * Subversion ID: $Id$
**/

class Output_HTML extends Output {
  
  var $head;
  
  function __construct(){
   $this->name = 'html';
   $this->head = array();
  }
  
  function run(){
   $ret = parent::run();
   Fusion::$_->hook('HTML/Header');
   return $ret;
  }
  
  function Header($template){
   $this->head[] = $template;
  }
  
  function Output($sub){
    $template = $this->Template('index');
    $template->head = (array) $this->head;
    $template->main = $sub;
    $template->Display();
  }

}

