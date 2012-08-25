<?php
class Template_Theme_Graphene_HTML_Page extends Template {
	public function title() {
		return $this->main->title;
	}
	public function blocks($b){
		if(isset($this->blocks[$b])){
?>
<div class="page-blocks-<?php echo $b; ?> page-blocks">
<?php $y = 0;
	foreach($this->blocks[$b] as $o => $order){
		$y ++; $z = 0;
		foreach($this->blocks[$b][$o] as $block){
			$z++;
			if($z == count($order) && $y == count($this->blocks[$b])){ $block->last = true; }
			$block->display();
		}
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
<div class="page-base clearfix hfeed">
<?php 	$this->blocks('left'); ?>
<?php 	$this->blocks('right'); ?>
<?php } ?>
<div class="page-main clearfix grid_16">
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
