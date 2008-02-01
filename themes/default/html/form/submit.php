<?php	

/**
 * Default Theme - HTML - Form Submit
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Form_Submit extends Template {

  function Display(){
?>
<div class="form_field form_field_submit">
 <input type="submit" name="<? echo $this->name; ?>" id="<? echo $this->id; ?>" value="<? echo $this->title; ?>" />
 <br clear="both">
</div>
<?
  }
  
}
