<?php

class Template_Theme_Default_HTML_User_Admin_Edit extends Template {
	public function display(){
?>		
<div class="user-admin-edit">
	<div class="user-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="user-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
