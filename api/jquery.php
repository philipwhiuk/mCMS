<?php

/**
 * jQuery API File
 *
 * Subversion ID: $Id: html.php 16 2007-12-26 19:47:06Z agentscorpion $
**/

class jQuery extends API  {

  static $files = array();

  function __construct(){
    $this->name = 'jQuery';
  }

  static function API_Load($fusion){
    $fusion->hooks['HTML/Header']['jQuery'] = true;
    $fusion->hooks['jQuery/Load']['jQuery'] = true;
    return true;
  }

  static function API_Hook_jQuery_Load($fusion, $files){
    jQuery::$files = array_merge_recursive(jQuery::$files, $files);
  }

  static function appender($prefix, $array, $suffix, $return = array()){
    foreach($array as $k => $v){
      if(is_array($v)){
        $return = self::appender($prefix . $k . '.', $v, $suffix, $return);
      } else {
        $return[] = $prefix . $v . $suffix;
      }
    }
    return $return;
  }

  static function API_Hook_HTML_Header(){
    $template = Fusion::$_->output->Template('jquery');
    $template->files = self::appender(Fusion::$_->config['root'] . 'jquery/', self::$files, '.js');
    Fusion::$_->output->Header($template);
  }

}
