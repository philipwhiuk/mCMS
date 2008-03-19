<?php

/**
 * CSS API File
 *
 * Subversion ID: $Id$
**/

class CSS extends API  {

  function __construct(){
    $this->name = 'css';
  }

  static function Load_API(){
    return array(
      'call' => array(
        'html_header' => array(
          'func' => array('CSS', 'HTML')
        )
      )
    );
  }

  static function HTML(){
    $template = Fusion::$_->output->Template('css');
    $template->file = Fusion::$_->config['root'] . 'themes/' . Fusion::$_->output->theme->folder . '/css/main.css';
    Fusion::$_->output->Header($template);
  }

}
