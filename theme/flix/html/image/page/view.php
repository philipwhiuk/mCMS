<?php

class Template_Theme_Flix_HTML_Image_Page_View extends Template {
	public function display(){
?>		
<div class="image page-image image-view page-image-view">
	<h1><?php echo $this->title; ?></h1>
	<div class="image-text">
		<?php echo $this->body; ?> 
	</div>
	<div class="image-files">
		<ul>
		<?php foreach($this->files as $file){ ?> 
			<li><a href="<?php echo $file['url']; ?>"><img src="<?php echo $file['src']; ?>" /></a>
				<?php echo $file['height']; ?> x <?php echo $file['width']; ?> - <?php echo $file['size']; ?>
			</li>
		<?php } ?>
		</ul> 
	</div>
</div>
<?php	
	}	
}