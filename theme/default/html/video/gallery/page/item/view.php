<?php

class Template_Theme_Default_HTML_Video_Gallery_Page_Item_View extends Template {

	public function display(){
?>
	<div class="gallery-video-item">
		<?php if($this->title != ''){ ?><h2><?php echo $this->title; ?></h2><?php } ?>
		<div class="gallery-video-item-body">
			<?php echo $this->body; ?>
		</div>
	</div>
<?php
	}
}
