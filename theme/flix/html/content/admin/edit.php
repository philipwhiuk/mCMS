<?php

class Template_Theme_Flix_HTML_Content_Admin_Edit extends Template {
	public function display(){
?>		
<div class="content-admin-edit">
	<div class="content-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="content-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
