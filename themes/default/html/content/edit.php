<?php	

/**
 * Default Theme - HTML - View Content
 *
 * Subversion ID: $Id:$
**/

require_once(dirname(__FILE__) . '/../content.php');

class Template_Default_HTML_Content_Edit extends Template_Default_HTML_Content {

  function Display(){
    ?>
    <!-- Content Block (Edit) -->
            <div class="block_title">
              <h1><? echo $this->title; ?></h1><? $this->modes(); ?>
            </div>
            <? echo $this->form->display(); ?>
    <!-- End Content Block (Edit) -->
    <?
  }
  
}
