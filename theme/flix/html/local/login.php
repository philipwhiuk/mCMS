<?php

class Template_Theme_Flix_HTML_Local_Login extends Template {
	
	public function display(){
?> 
<div class='local local-login login-local'>
<?php 
	$this->form->display();		
?>
</div>
<?php		
	}
	
}