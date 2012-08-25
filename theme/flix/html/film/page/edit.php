<?php

class Template_Theme_Default_HTML_Content_Page_Edit extends Template {
	public function display(){
?>		
<div class="content page-content content-edit page-content-edit">
	<h1><?php echo $this->title; ?></h1>
	<div class="content-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}