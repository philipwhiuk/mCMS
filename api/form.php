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
    $this->data = array();
    $this->error = false;
    $this->errors = array();
    $this->submit = false;
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
    
    // Have we submitted the form?
    if(isset($_POST[$this->id])){
      $this->submit = true;   // Yes
      
      // Are the fields valid?
      foreach($this->fields as $f => &$field){
        $messages = $field->Validate($_POST[$this->id][$f]);
        if(count($messages) > 0){
          $this->error = true;
          $this->form->errors[$f] = $messages;
        }
      }
      
      // Return if false
      if($this->error){
        return false;
      }

      // Extract data
      foreach($this->fields as $f => &$field){
        $this->data[$f] = $field->value;
      }
      
      return $this->data;
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
