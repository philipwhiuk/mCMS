<?php

class Template_Theme_Flix_HTML_Film_Admin_Edit extends Template {
	public function display(){
?>		
<div class="film-admin-edit">
	<div class="film-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="film-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
