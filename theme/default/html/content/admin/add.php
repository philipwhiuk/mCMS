<?php

class Template_Theme_Default_HTML_Content_Admin_Add extends Template {
	public function display(){
?>		
<div class="content-admin-add">
	<div class="content-admin-add-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="content-admin-add-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
