<?php

class Template_Theme_Default_HTML_Topic_Admin_Edit extends Template {
	public function display(){
?>		
<div class="topic-admin-edit">
	<div class="topic-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="topic-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
