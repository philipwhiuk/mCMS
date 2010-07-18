<?php

class Template_Theme_Flix_HTML_Film_Festival_Admin_Edit extends Template {
	public function display(){
?>		
<div class="film_festival-admin-edit">
	<div class="film_festival-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="film_festival-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
