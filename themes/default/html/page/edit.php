<?php	

/**
 * Default Theme - HTML - View Page
 *
 * Subversion ID: $Id:$
**/

require_once(dirname(__FILE__) . '/../page.php');

class Template_Default_HTML_Page_Edit extends Template_Default_HTML_Page {

  function Display(){
?>
<!-- Page -->
<div class="page">
<?
    $this->zone->display();
?>
  <br clear="both" />
</div>
<? $this->Modes(); ?>
<!-- End Page -->
<?
  }  
  
}
