<?php

class Template_Theme_Default_HTML_Login_Page extends Template {
	
	public function display(){
?>		
<div class="login page-login">
	<h1><?php  ?></h1>
<?php 
	$this->login->display();
?>
</div>
<?php
	}
	
}