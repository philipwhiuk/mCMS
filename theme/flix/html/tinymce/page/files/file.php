<?php

class Template_Theme_Default_HTML_TinyMCE_Page_Files_File extends Template {
	
	public function __construct($data){
		parent::__construct($data);
		$this->html->head('jquery',
'<script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>');
		$this->html->head('tinymce/filebrowser',
'<script language="javascript" type="text/javascript" src="' . $this->theme->url('js/tinymce/tiny_mce_popup.js') . '"></script>');
		$this->html->head('tinymce/filebrowser/file', 
'<script language="javascript" type="text/javascript">
	$(function(){
		$("div.tinymce-files-show a").click(function(){ 
			var win = tinyMCEPopup.getWindowArg("window");
			
			var URL = this.toString();

	        // insert information now
	        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
			
	        // close popup window
	        tinyMCEPopup.close();
	        return false;
	   });
	});
</script>');
	}
		
	public function display(){
?>		
<div class="tinymce page-tinymce tinymce-files tinymce-files-file page-tinymce-files-file page-tinymce-files">
	<h1><?php echo $this->title; ?></h1>
	<div class="tinymce-files-list">
		<ul>
			<?php foreach($this->files as $file){ ?>
				<li>
					<a href="<?php echo $file['url']; ?>">
						<?php echo $file['name']; ?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php if($this->file !== false){ ?> 
	<div class="tinymce-files-show">
		<div class="tinymce-files-show-inner">
			<h2><?php echo $this->file['name']; ?></h2>
			<dl>
				<dt>
					<?php echo $this->file['size_label']; ?>
				</dt>
				<dd>
					<?php echo $this->file['size']; ?>
				</dd>
				<dt>
					<?php echo $this->file['mime_label']; ?>
				</dt>
				<dd>
					<?php echo $this->file['mime']; ?>
				</dd>
				<dt>
					<?php echo $this->file['path_label']; ?>
				</dt>
				<dd>
					<a href="<?php echo $this->file['path']; ?>"><?php echo $this->file['name']; ?></a>
				</dd>
			</dl>
		</div>
	</div>
	<?php } ?> 
</div>
<?php	
	}	
}