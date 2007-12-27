<?

/**
 * Default Theme - HTML - View Content
 *
 * Subversion ID: $Id:$
**/


class Template_Default_HTML_Content extends Template {

  function modes(){
    if(count($this->modes) > 1){
?>
<div class="block_modes">
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
