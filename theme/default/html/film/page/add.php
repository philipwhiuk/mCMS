<?php

class Template_Theme_Flix_HTML_Film_Page_Add extends Template {
	public function display(){
?>		
<div class="content page-content content-add page-content-add">
	<h1><?php echo $this->title; ?></h1>
	<div class="content-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}