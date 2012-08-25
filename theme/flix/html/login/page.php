<?php

class Template_Theme_Flix_HTML_Login_Page extends Template {
	
	public function display(){
?>		
<div class="page-view login page-login page-login-view login-view">
	<h1>Login</h1>
<?php 
	$this->login->display();
?>
</div>
<?php
	}
	
}