<?php

/**
 * Form API Field File
 *
 * Subversion ID: $Id: index.php 16 2007-12-26 19:47:06Z agentscorpion $
**/

class Field {

  function __construct($id, $data, $name, $idb){
    $this->error = false;
    $this->fname = $name . '[' . $id . ']';
    $this->name = $name;
    $this->id = $idb . '_' . $id;
    foreach($data as $f => $v){
      $this->$f = $v;
    }
    $this->Run();
  }
  
  function Run(){
  }
  
  function Validate($value){
    $this->value = $value;
    $v = explode(',', $this->validation);
    $errors = array();
    foreach($v as $i){
      if($i != ''){
        $f = 'Form_Validation_' . $i;
        if(function_exists($f)){
          $reason = '';
          if($reason = $f(&$this->value)){
            $errors[] = $reason;
          }
        }
      }
    }
    return $errors;
  }
  
  function Output(){ 
    $template = new Template;
    return $template;
  }

}

class Field_Textbox extends Field {
  
  function Output(){ 
    $template = Fusion::$_->output->template('form/textbox');
    $template->value = $this->value;
    $template->id = $this->id;
    $template->name = $this->fname;
    $template->error = $this->error;
    $template->title = $this->title;
    return $template;
  }

}

class Field_Submit extends Field {
  
  function Validate($value){
    if(isset($value)){
      $this->value = true;
    } else {
      $this->value = false;
    }
    return array();
  }
  
  function Output(){ 
    $template = Fusion::$_->output->template('form/submit');
    $template->id = $this->id;
    $template->name = $this->fname;
    $template->title = $this->title;
    return $template;
  }

}

class Field_Textarea extends Field {
  
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
