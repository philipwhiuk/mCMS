<?php

/**
 * CSS API File
 *
 * Subversion ID: $Id$
**/

class CSS {

  function __construct(){
    $this->name = 'css';
  }

  static function API_Load($fusion){
    $fusion->hooks['HTML/Header'][] = 'css';
    return true;
  }

  static function API_Hook_HTML_Header(){
    $template = Fusion::$_->output->Template('css');
    $template->file = Fusion::$_->config['root'] . 'themes/' . Fusion::$_->output->theme->folder . '/css/main.css';
    Fusion::$_->output->Header($template);
  }

}
