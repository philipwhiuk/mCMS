<?php	

/**
 * Default Theme - HTML - View Page
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Page_View extends Template {

  function Display(){
?>
<!-- Page -->
<div class="page">
<?
    $this->zone->display();
?>
  <br clear="both" />
</div>
<!-- End Page -->
<?
  }  
  
}
