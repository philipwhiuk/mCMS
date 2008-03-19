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
  
  function Header($template){            // HTML Header Helper Function
   $this->head[] = $template;
  }
  
  function Output($sub){
    $template = $this->Template('index');
    Fusion::$_->api_call('html_header');    // Grab HTML Header
    $template->head = (array) $this->head;
    $template->main = $sub;
    $template->Display();
  }

}

