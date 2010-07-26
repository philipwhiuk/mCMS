<?php
class Template_Theme_Default_HTML_User_Status_Page_Block_Login_View extends Template {
	public function display() {
		?>
		<div class="page-view page-block-view user_status user_status-view page-block-user_status-view">
		<?php $this->form->display(); ?>
		</div><?php		
	}
}