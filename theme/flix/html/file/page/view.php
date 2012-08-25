<?php

class Template_Theme_Flix_HTML_File_Page_View extends Template {
	public function display(){
?>		
<div class="page-view file page-file file-view page-file-view">
	<h1><?php echo $this->name; ?></h1>
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
			<a href="<?php echo $this->path; ?>"><?php echo $this->name; ?></a>
		</dd>
	</dl>
</div>
<?php	
	}	
}