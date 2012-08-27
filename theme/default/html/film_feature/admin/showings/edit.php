<?php
class Template_Theme_Default_HTML_Film_Feature_Admin_Showing_Edit extends Template {
	public function display(){
?>		
<div class="film_feature-admin-showing_edit">
	<div class="film-admin-showing_edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="film_feature-admin-showing_edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
