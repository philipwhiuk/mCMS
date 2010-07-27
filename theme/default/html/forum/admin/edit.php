<?php

class Template_Theme_Default_HTML_Forum_Admin_Edit extends Template {
	public function display(){
?>		
<div class="forum-admin-edit">
	<div class="forum-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="forum-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
