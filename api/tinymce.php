<?php

/**
 * TinyMCE API File
 *
 * Subversion ID: $Id$
**/

class Field_Richtext extends Field {
  
  function Run(){
    TinyMCE::$active = true;
  }
  
  function Output(){ 
    $template = Fusion::$_->output->template('form/textarea');
    $template->error = $this->error;
    $template->value = $this->value;
    $template->id = $this->id;
    $template->name = $this->fname;
    $template->title = $this->title;
    return $template;
  }
  
}

class TinyMCE extends API  {

  static $active = false;
  
  static function API_Load($fusion){
    $fusion->hooks['HTML/Header']['tinymce'] = true;
    return true;
  }

  static function API_Hook_HTML_Header(){
    if(TinyMCE::$active){
      $template = Fusion::$_->output->Template('tinymce');
      $template->file = Fusion::$_->config['root'] . 'tinymce/tiny_mce_gzip.js';
      // Allow configuration of TinyMCE Here!
      
      // End configuration
      Fusion::$_->output->Header($template);
    }
  }
  
}
