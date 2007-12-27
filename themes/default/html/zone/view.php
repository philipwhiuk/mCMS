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
    <div class="zone_outer">
      <div class="zone" style="width: <?php echo $this->width; ?>%;">
        <div class="zone_inner">
<?
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
        $block->display();
      }
?>
      <br clear="both" />
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
