<?php

class Template_Theme_Default_HTML_Content_Page_Block_View extends Template {
	public function display(){
?>		
<div class="content page-block-content">
	<?php var_dump($this);
		
		if(isset($this->title && $this->title != "") { ?><h1><?php echo $this->title; ?></h1><?php } ?>
	<?php echo $this->body; ?> 
</div>
<?php	
	}	
}