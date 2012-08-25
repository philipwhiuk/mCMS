<?php

class Template_Theme_Flix_HTML_Event_Admin_Edit extends Template {
	public function display(){
?>		
<div class="event-admin-edit">
	<div class="event-admin-edit-head">
		<h1><?php echo $this->title; ?></h1>
	</div>
	<div class="event-admin-edit-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}
