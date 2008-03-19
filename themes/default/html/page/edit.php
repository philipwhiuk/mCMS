<?php	

/**
 * Default Theme - HTML - View Page
 *
 * Subversion ID: $Id:$
**/

require_once(dirname(__FILE__) . '/../page.php');

class Template_Default_HTML_Page_Edit extends Template_Default_HTML_Page {

 function __construct(){
  
 }

 function Display(){
  ?>
  <!-- Page -->
  <div class="page page_edit">
  <?
    $this->zone->display();
  ?>
   <br clear="both" />
  </div>
  <br clear="both" />
  <? $this->Modes(); ?>
  <!-- End Page -->
  <?
 }  

}
