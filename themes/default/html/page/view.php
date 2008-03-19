<?php	

/**
 * Default Theme - HTML - View Page
 *
 * Subversion ID: $Id:$
**/

require_once(dirname(__FILE__) . '/../page.php');

class Template_Default_HTML_Page_View extends Template_Default_HTML_Page {

  function Display(){
?>
<!-- Page -->
<div class="page page_view">
<?php
  $this->layout->display();
?>
</div>
<br clear="both" />
<?php $this->Modes(); ?>
<!-- End Page -->
<?php
  }  
  
}
