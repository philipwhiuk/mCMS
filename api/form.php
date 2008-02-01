<?php

/**
 * Form API File
 *
 * Subversion ID: $Id: index.php 16 2007-12-26 19:47:06Z agentscorpion $
**/

class Form {

  function __construct($id, $link){
    $this->id = $id;
    $this->link = $link;
    $this->fields = array();
  }
  
  function field($f, $data){
    $e = explode(',',$data['type']);
    foreach($e as $c){
      $c = 'Field_' . $c;
      if(class_exists($c)){
        $this->fields[$f] = new $c($f, $data, $this->id, $this->id);
        return;
      }
    }
    $this->fields[$f] = new Field($f, $data, $this->id, $this->id);
  }
  
  function run(){
    $this->data = array();
    $this->error = false;
    if(isset($_POST[$this->id])){
      $this->submit = true;
      foreach($this->fields as $f => &$field){
        $error = $field->run($_POST[$this->id][$f], &$form, &$this->data[$f]);
        $this->error = $this->error ? true : $error;
      }
      if(!$this->error){
        return true;
      }
    }
    return false;
  }
  
  function output(){
    $template = Fusion::$_->output->template('form');
    $template->id = $this->id;
    $template->link = $this->link;
    foreach($this->fields as $f => &$field){
      $template->fields[$f] = $field->output();
    }
    return $template;
  }

}
