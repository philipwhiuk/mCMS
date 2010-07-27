<?php

class Template_Theme_Default_HTML_File_Admin_Edit extends Template {
	public function display(){
?>		
<div class="file-admin-edit">
	<div class="file-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="file-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
