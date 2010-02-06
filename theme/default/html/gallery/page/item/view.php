<?php

class Template_Theme_Default_HTML_Gallery_Page_Item_View extends Template {

	public function display(){
?>
	<div class="gallery page-gallery gallery-item page-gallery-item gallery-item-view page-gallery-item-view">
		<div class="gallery-info">
			<?php if($this->gallery['title'] != ''){ ?><h1><?php echo $this->gallery['title']; ?></h1><?php } ?>
			<?php echo $this->gallery['body']; ?>
		</div>
		<div class="gallery-item">
			<?php $this->item->display(); ?>
		</div>
	</div>
<?php
	}

}
