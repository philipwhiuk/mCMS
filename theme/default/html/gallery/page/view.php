<?php

class Template_Theme_Default_HTML_Gallery_Page_View extends Template {

	public function display(){
?>
<div class="gallery page-gallery gallery-view page-gallery-view"> 
	<?php if($this->gallery['title'] != ''){ ?><h1><?php echo $this->gallery['title']; ?></h1><?php } ?>
	<?php echo $this->gallery['body']; ?>

<?php
	$backg = array();
	$g =& $this->gallery;
	if(count($this->gallery['children']) != 0){
?>
	<div class="gallery-menu"> 
<?php
		$cont = true;
		while($cont){
			$backg[] = $g;
			$next = false;
			if(count($g['children']) > 0){
?>
		<ul> 
<?php
			foreach($g['children'] as $child){
?>
			<li <?php if($child['selected']){ ?> class="selected" <?php } ?> style="width: <?php echo 100 / count($g['children']); ?>%;"><a href="<?php echo $child['surl']; ?>"><?php echo $child['title']; ?></a></li> 
<?php
				if($child['selected']){
					$next = $child;
				}
			}
?>
		</ul>
<?php
			}

			if($next !== false){ 
				$g = $next;
			} else {
				$cont = false;
			}

		}
?>
	</div>
<?php

	}

	if(count($g['objects']) > 0 && isset($g['objselected'])){
?>
	<div class="gallery-items">
		<?php 
			$g['objects'][$g['objselected']]->selected = true;
			$g['objects'][$g['objselected']]->display($g['objects']);			
		?>
	</div>
<?php
	} 
?>
</div> 
<?php
	}

}
