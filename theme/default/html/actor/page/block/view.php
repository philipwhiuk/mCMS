<?php

class Template_Theme_Flix_HTML_Content_Page_Block_View extends Template {
	public function display(){
?>		
<div class="content page-block-content">
	<h1><?php echo $this->title; ?></h1>
	<?php echo $this->body; ?> 
</div>
<?php	
	}	
}