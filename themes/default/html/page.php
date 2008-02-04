<?php	

/**
 * Default Theme - HTML - Page
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Page extends Template {

  function Modes(){
    if(count($this->modes) > 1){
?>
<div class="page_modes">
  <ul>
    <? foreach($this->modes as $mode => $data){ ?>
      <li><a <? if($data['selected']){ ?> class="selected" <? } ?> href="<? echo $data['link']; ?>"><? echo $data['name']; ?></a></li>
    <? } ?>
  </ul>
</div>
<?
    }
?>
<br clear="both" />
<?
  }
  
}
