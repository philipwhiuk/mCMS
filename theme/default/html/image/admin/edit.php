<?php

class Template_Theme_Default_HTML_Image_Admin_Edit extends Template {
	public function display(){
?>		
<div class="image-admin-edit">
	<div class="image-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="image-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
