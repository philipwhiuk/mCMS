<?php

class Template_Theme_Default_HTML_Film_Feature_Admin_Edit extends Template {
	public function display(){
?>		
<div class="film_feature-admin-edit">
	<div class="film-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="film_feature-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
