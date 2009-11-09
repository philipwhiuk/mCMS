<?php

class Template_Theme_Default_HTML_File_Page_List extends Template {
	
	public $files = array();
	
	public function display(){
?>		
<div class="file page-file file-list page-file-list">
	<h1><?php echo $this->title; ?></h1>
	<ul>
		<?php foreach($this->files as $file){ ?>
		<li><a href="<?php echo $file['url']; ?>"><?php echo $file['name']; ?></a></li>
		<?php } ?>
	</ul> 
</div>
<?php	
	}	
}