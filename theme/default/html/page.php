<?php

class Template_Theme_Default_HTML_Page extends Template {
	public function blocks($block){
		if(isset($this->blocks[$block])){
?>
<div class="page-blocks-top page-blocks">
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
<div class="page">
<?php $this->blocks('top'); ?>
<?php $this->blocks('left'); ?>
<?php $this->blocks('right'); ?>
<div class="page-main">
<?php $this->main->display(); ?>
</div>
<?php $this->blocks('bottom'); ?>
</div>
<?php	
	}	
}