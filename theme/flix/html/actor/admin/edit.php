<?php

class Template_Theme_Flix_HTML_Actor_Admin_Edit extends Template {
	public function display(){
?>		
<div class="actor-admin-edit">
	<div class="actor-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="actor-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
