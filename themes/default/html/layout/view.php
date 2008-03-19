<?php	

/**
 * Default Theme - HTML - View Layout
 *
 * Subversion ID: $Id:$
**/

require_once(dirname(__FILE__) . '/../layout.php');

class Template_Default_HTML_Layout_View extends Template_Default_HTML_Layout {

  function Display(){
?>
<!-- Layout -->
<div class="layout layout_view">
  <div class="zone_row">
<?
  foreach($this->layout as $zone){
    $zone->display();
  }
?>
    <br clear="both" />
  </div>
</div>
<br clear="both" />
<? $this->Modes(); ?>
<!-- End Layout -->
<?
  }  
  
}
