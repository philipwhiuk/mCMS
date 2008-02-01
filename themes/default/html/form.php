<?php	

/**
 * Default Theme - HTML - Form
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Form extends Template {

  function Display(){
?>
<form action="<? echo $this->link; ?>" method="post" id="<? echo $this->id; ?>">
<? 
    foreach($this->fields as $f => $field){ 
      $field->display();
    }
?>
</form>
<?
  }
  
}
