<?php	

/**
 * Default Theme - HTML - View Zone
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Zone_View extends Template {

  function Display(){
    ?>
  <!-- Zone -->
    <div class="zone" style="width: <?php echo $this->width; ?>%;">
      <div class="zone_a" style="width: 100%;">
        <div class="zone_b">
          <?
            $r = true;
            foreach($this->zones as $r => &$row){
              if(!$r){ ?> <br clear="both" /> <?php } else { $r = false; } 
              foreach($row as $c => &$col){
                foreach($col as $z => &$zone){
                  $zone->display();
                }
              }
            }
            if(count($this->zones) > 0 && count($this->blocks) > 0){
              ?> <br clear="both" /> <?php
            }
              foreach($this->blocks as $r => &$row){
                foreach($row as $c => &$block){
          ?>
                <div class="block">
                  <div class="block_a" style="width: <?php echo $block->width; ?>%;">
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
          ?>
          <?php
              }
          ?>
        </div>
      </div>
    </div>
  <!-- End Zone -->
    <?
  }


}
