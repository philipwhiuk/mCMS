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
      <div class="block_outer">
        <div class="block" style="width: <?php echo $this->width; ?>%;">
          <div class="block_inner">
            <div class="block_title">
              <h1><? echo $this->title; ?></h1><? $this->modes(); ?>
            </div>
            <? echo $this->form->display(); ?>
          </div>
        </div>
      </div>
    <!-- End Content Block (Edit) -->
    <?
  }
  
}
