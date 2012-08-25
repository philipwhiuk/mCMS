<?php

class Template_Theme_Flix_HTML_Image_Page_File extends Template {
	public function display(){
?>		
<div class="image page-image image-file page-image-file">
	<h1><?php echo $this->name; ?></h1>
	<div class="image-file-info">
		<img src="<?php echo $this->path; ?>" />
		<dl>
			<dt>
				<?php echo $this->size_label; ?>
			</dt>
			<dd>
				<?php echo $this->size; ?>
			</dd>
			<dt>
				<?php echo $this->mime_label; ?>
			</dt>
			<dd>
				<?php echo $this->mime; ?>
			</dd>
			<dt>
				<?php echo $this->path_label; ?>
			</dt>
			<dd>
				<a href="<?php echo $this->path; ?>"><?php echo $this->filename; ?></a>
			</dd>
			<dt>
				<?php echo $this->width_label; ?>
			</dt>
			<dd>
				<?php echo $this->width; ?>
			</dd>
			<dt>
				<?php echo $this->height_label; ?>
			</dt>
			<dd>
				<?php echo $this->height; ?>
			</dd>
		</dl>
	</div>
</div>
<?php	
	}	
}