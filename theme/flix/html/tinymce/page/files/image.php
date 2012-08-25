<?php

class Template_Theme_Default_HTML_TinyMCE_Page_Files_Image extends Template {
	
	public function __construct($data){
		parent::__construct($data);
		$this->html->head('jquery',
'<script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
		$this->html->head('tinymce/filebrowser',
'<script language="javascript" type="text/javascript" src="' . $this->theme->url('js/tinymce/tiny_mce_popup.js') . '"></script>');
		$this->html->head('tinymce/filebrowser/image', 
'<script language="javascript" type="text/javascript">
	$(function(){
		$("div.tinymce-image-files a").click(function(){ 
			var win = tinyMCEPopup.getWindowArg("window");
			
			var URL = this.toString();

	        // insert information now
	        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
	
	        // are we an image browser
	        if (typeof(win.ImageDialog) != "undefined") {
	            // we are, so update image dimensions...
	            if (win.ImageDialog.getImageData)
	                win.ImageDialog.getImageData();
	
	            // ... and preview if necessary
	            if (win.ImageDialog.showPreviewImage)
	                win.ImageDialog.showPreviewImage(URL);
	        }
	
	        // close popup window
	        tinyMCEPopup.close();
	        return false;
	   });
	});
</script>');
	}
		
	public function display(){
?>		
<div class="tinymce page-tinymce tinymce-files tinymce-files-image page-tinymce-files-image page-tinymce-files">
	<h1><?php echo $this->title; ?></h1>
	<div class="tinymce-files-list">
		<ul>
			<?php foreach($this->images as $image){ ?>
				<li>
					<a href="<?php echo $image['url']; ?>">
						<?php echo $image['name']; ?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php if($this->image !== false){ ?> 
	<div class="tinymce-files-show">
		<div class="tinymce-files-show-inner">
			<h2><?php echo $this->image['name']; ?></h2>
			<div class="tinymce-image-files">
				<ul>
				<?php foreach($this->image['files'] as $file){ ?> 
					<li><a href="<?php echo $file['src']; ?>"><img src="<?php echo $file['src']; ?>" /></a>
						<?php echo $file['height']; ?> x <?php echo $file['width']; ?> - <?php echo $file['size']; ?>
					</li>
				<?php } ?>
				</ul> 
			</div>
		</div>
	</div>
	<?php } ?> 
</div>
<?php	
	}	
}