<?php

class Template_Theme_Flix_HTML_Page extends Template {
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
						$block->display($b);
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
	<div class="page-base">
<!--	<div class="page-left"> -->
	<?php 	$this->blocks('left'); ?>
<!--	</div> -->
<!--	<div class="page-right"> -->
	<?php 	$this->blocks('right'); ?>
<!--	</div> -->
	<?php } ?>
	<div class="page-main">
		<div class="page-center">
			<?php if(isset($this->blocks['cl'])) { ?>		
				<div class="center-left">
					<div class="inner"><?php 	$this->blocks("cl"); ?></div>
				</div>
			<?php } ?>
			<div class="center-right">
				<?php if(isset($this->blocks['crt'])) { ?>	
				<div class="center-right-top">
					<div class="inner"><?php 	$this->blocks('crt'); ?></div>
				</div>
				<?php } ?>
				<div class="center-right-bottom">
					<?php if(isset($this->blocks['crbl'])) { ?>
					<div class="center-right-bottom-left">
						<div class="inner"><?php 	$this->blocks('crbl'); ?></div>
					</div>
					<?php } if(isset($this->blocks['crbr'])) { ?>
					<div class="center-right-bottom-right">
						<div class="inner"><?php 	$this->blocks('crbr'); ?></div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php 	$this->blocks('center'); ?>
			<?php $this->main->display(); ?>
		</div>
	</div>
</div>
<?php if(!$this->inline){ ?>
<?php $this->blocks('bottom'); ?>
<?php } ?>
</div>
<?php	
	}	
}
