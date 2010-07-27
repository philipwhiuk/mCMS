<?php

class Template_Theme_Default_HTML_News_Admin_Edit extends Template {
	public function display(){
?>		
<div class="news-admin-edit">
	<div class="news-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="news-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
