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
			$percent = 100; $pages = count($g['children']); 
			foreach($g['children'] as $child){
				$width = round($percent / $pages, 2);
				$percent -= $width; $pages --;
?>
			<li <?php if($child['selected']){ ?> class="selected" <?php } ?> style="width: <?php echo $width; ?>%;"><a href="<?php echo $child['surl']; ?>"><?php echo $child['title']; ?></a></li> 
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

	if(isset($g['pages']) && count($g['pages']) > 0){
?>
	<div class="gallery-pages">
		<ul>
		<?php
			$pages = count($g['pages']); $percent = 100;
			foreach($g['pages'] as $k => $page){
				$width = round($percent / $pages,2);
				$percent -= $width; $pages --;
		?>
			<li style="width: <?php echo $width; ?>%;"<?php if($page['selected']){ ?> class="selected"<?php } ?>><a href="<?php echo $page['surl']; ?>"><?php echo $k; ?></a></li>
		<?php
			}
		?>
		</ul>
	</div>
<?
	}
?>
</div> 
<?php
	}

}
