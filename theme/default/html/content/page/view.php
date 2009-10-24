<?php

class Template_Theme_Default_HTML_Content_Page_View extends Template {
	public function display(){
?>		
<div class="content page-content">
	<h1><?php echo $this->title; ?></h1>
	<div class="content-text">
		<?php echo $this->body; ?> 
	</div> 
</div>
<?php	
	}	
}