<?php	

/**
 * Default Theme - HTML - Form Textarea
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Form_Textarea extends Template {

  function Display(){
?>
<div class="form_field form_field_textarea">
 <label for="<? echo $this->id; ?>">
  <? echo $this->title; ?>
 </label>
 <br clear="both">
 <textarea <? if($this->error){ ?> class="form_field_error" <? } ?> name="<? echo $this->name; ?>" id="<? echo $this->id; ?>"><? echo $this->value; ?></textarea>
 <br clear="both">
</div>
<?
  }
  
}
