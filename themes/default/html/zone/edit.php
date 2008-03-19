<?php	

/**
 * Default Theme - HTML - View Zone
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Zone_Edit extends Template {

  function Display(){
    ?>
  <!-- Zone -->
    <div class="zone" style="width: <?php echo $this->width; ?>%;">
      <div class="zone_a">
        <div class="zone_header">
          <div class="zone_tools">
          <? 
          if(isset($this->tools['new_zone'])){ 
          ?>
            <a class="new_zone" href="<? echo $this->tools['new_zone']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/folder-new.png" alt="<? echo $this->tools['new_zone']['name']; ?>" title="<? echo $this->tools['new_zone']['name']; ?>" />
            </a>
          <? 
          }
          if(isset($this->tools['new_block'])){
          ?>
            <a class="new_block" href="<? echo $this->tools['new_block']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/document-new.png" alt="<? echo $this->tools['new_block']['name']; ?>" title="<? echo $this->tools['new_block']['name']; ?>" />
            </a>
          <?
          }
          if(isset($this->tools['edit_zone'])){
          ?>
            <a class="edit_zone" href="<? echo $this->tools['edit_zone']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/document-properties.png" alt="<? echo $this->tools['edit_zone']['name']; ?>" title="<? echo $this->tools['edit_zone']['name']; ?>" />
            </a>
          <?
          }
          if(isset($this->tools['move_zone_left'])){
          ?>
            <a class="move_zone_left" href="<? echo $this->tools['move_zone_left']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/go-previous.png" alt="<? echo $this->tools['move_zone_left']['name']; ?>" title="<? echo $this->tools['move_zone_left']['name']; ?>" />
            </a>
          <?
          }
          if(isset($this->tools['move_zone_up'])){
          ?>
            <a class="move_zone_up" href="<? echo $this->tools['move_zone_up']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/go-up.png" alt="<? echo $this->tools['move_zone_up']['name']; ?>" title="<? echo $this->tools['move_zone_up']['name']; ?>" />
            </a>
          <?
          }
          /*
          ?>
            <a class="move_zone_up" href="<? echo $this->tools['edit_zone']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/go-up.png" />
            </a>
            <a class="move_zone_down" href="<? echo $this->tools['edit_zone']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/go-down.png" />
            </a>
            <a class="move_zone_right" href="<? echo $this->tools['edit_zone']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/go-next.png" />
            </a>
            <a class="delete_zone" href="<? echo $this->tools['delete_zone']['url']; ?>">
              <img src="<? echo Fusion::$_->output->theme->base; ?>/images/edit-delete.png" />
              <? echo $this->tools['delete_zone']['name']; ?>
            </a>
        <?
        */
        ?>
          </div>
          <? echo $this->name; ?>
          <br clear="both" />
        </div>
        <div class="zone_b">
          <? $this->Display_Inner(); ?>
          <br clear="both" />
        </div>
      </div>
      <br clear="both" />
    </div>
  <!-- End Zone -->
    <?
  }
  
  function Display_Inner (){
    foreach($this->zones as $r => &$row){
      foreach($row as $c => &$col){
        foreach($col as $z => &$zone){
          $zone->display();
        }
      }
?>
<br clear="both" />
<?php
    }
    
    foreach($this->blocks as $r => &$row){
      foreach($row as $c => &$block){
?>
      <div class="block">
        <div class="block_a" style="width: <?php echo $block->width; ?>%;">
            <div class="block_header">
              <div class="block_tools">
                <a class="edit_block" href="<? echo $this->tools['edit_block']['url']; ?>">
                  <img src="<? echo Fusion::$_->output->theme->base; ?>/images/document-properties.png" />
                  <? echo $this->tools['edit_block']['name']; ?>
                </a>
                <a class="delete_block" href="<? echo $this->tools['delete_block']['url']; ?>">
                  <img src="<? echo Fusion::$_->output->theme->base; ?>/images/edit-delete.png" />
                  <? echo $this->tools['delete_block']['name']; ?>
                </a>
              </div>
              <? echo $block->name; ?>
              <br clear="both" />
            </div>
          <div class="block_b">
  <?
        $block->display();
?>
          </div>
          <br clear="both" />
        </div>
      </div>
<?
      }
    }
    

  }


}
