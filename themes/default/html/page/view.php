<?php	

/**
 * Default Theme - HTML - View Page
 *
 * Subversion ID: $Id:$
**/

class Template_Default_HTML_Page_View extends Template {

  function Display(){
    $this->zones[] =  array(
      'zones' => array(array('block' => new stdClass)),
      'width' => 100
    );
?>
<!-- Page -->
<div class="page">
<? $this->Zone($this->zones); ?>
  <br clear="both" />
</div>
<!-- End Page -->
    <?
  }
  
  function Zone($zones){
    foreach($zones as $zone){
      ?>
  <!-- Zone -->
    <div class="zone_outer">
       <div class="zone" style="width: <? echo $zone['width']; ?>%;">
        <div class="zone_inner">
<?
          if(isset($zone['blocks'])){
            $this->Blocks($zone['blocks']);
          } elseif(isset($zone['zones'])) {
            $this->Zone($zone['zones']);
          }
?>
        </div>
      </div>
    </div>
  <!-- End Zone -->
<?
    }  
  }
  
  function Blocks($blocks){
    foreach($blocks as $block){
      ?>
  <!-- Block -->
    <div class="block_outer">
       <div class="block">
        <div class="block_inner">
<?
          $block->Display();
?>
        </div>
      </div>
    </div>
  <!-- End Zone -->
<?
    }  
    
  }
  
  
}
