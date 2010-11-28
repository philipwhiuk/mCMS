<?php

class Template_Theme_Default_HTML_Raven_Login extends Template {
	
	public function display(){
?> 
<div class='raven raven-login login-raven'>
	<a href="<?php echo $this->url; ?>">
		<img src="<?php echo $this->theme->url('images/raven/ravenlogo.gif'); ?>">
		<p>
			Login using Raven.
		</p>
	</a>
</div>
<?php		
	}
	
}
