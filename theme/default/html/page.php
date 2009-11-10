<?php

class Template_Theme_Default_HTML_Page extends Template {
	public function blocks($block){
		if(isset($this->blocks[$block])){
?>
<div class="page-blocks-<?php echo $block; ?> page-blocks">
<?php 
	foreach($this->blocks[$block] as $block){
		$block->display();
	}
?>
</div>
<?php
		}	
	}
	
	public function display(){
?>		
<div class="page <?php if($this->inline){ ?>page-inline<?php } ?>">
<?php if(!$this->inline){ ?>
<?php 	$this->blocks('top'); ?>
<div class="page-base">
<?php 	$this->blocks('left'); ?>
<?php 	$this->blocks('right'); ?>
<?php } ?>
<div class="page-main">
<?php $this->main->display(); ?>
</div>
</div>
<?php if(!$this->inline){ ?>
<?php $this->blocks('bottom'); ?>
<?php } ?>
</div>
<?php	
	}	
}