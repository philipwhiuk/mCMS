<?php	

/**
 * Default Theme - HTML - Form Textbox
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Form_Textbox extends Template {

  function Display(){
?>
<div class="form_field form_field_textbox">
 <label for="<? echo $this->id; ?>">
  <? echo $this->title; ?>
 </label>
 <input type="text" <? if($this->error){ ?> class="form_field_error" <? } ?> name="<? echo $this->name; ?>" id="<? echo $this->id; ?>" value="<? echo $this->value; ?>" />
 <br clear="both">
</div>
<?
  }
  
}
