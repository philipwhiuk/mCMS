<?php

class Template_Theme_Flix_HTML_Video_Gallery_Page_View extends Template {

	public function display($others = array()){
		 $p = count($others);
?>
		<div class="gallery-items-video-selector">
			<ul>
<?php
			foreach($others as $child){
?>
			<li <?php if(isset($child->selected) && $child->selected){ ?> class="selected" <?php } ?> style="width: <?php echo 100 / $p; ?>%;"><a href="<?php echo $child->surl; ?>"><?php echo $child->title; ?></a></li> 
<?php
			}
?>
			</ul>
		</div>
		<div class="gallery-items-video-selected">
			<?php echo $this->body; ?>
		</div><?php
	}


}
