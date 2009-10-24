<?php

class Template_Theme_Default_HTML_Main extends Template {
	public function display(){
		header('Content-type: text/html; charset=utf-8')
?>
<html>
	<head>
		<link rel="stylesheet" href="<?php echo $this->theme->url('css/main.css'); ?>" type="text/css">
	</head>
	<body>
<?php 
	$this->main->display();
?>
	</body>
</html>
<?php	
	}	
}