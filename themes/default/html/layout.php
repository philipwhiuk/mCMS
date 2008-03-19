<?php	

/**
 * Default Theme - HTML - Layout
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Layout extends Template {

  function Modes(){
    if(count($this->modes) > 1){
?>
<div class="layout_modes">
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
